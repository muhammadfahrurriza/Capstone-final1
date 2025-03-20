<!-- resources/views/livewire/camera-capture.blade.php -->
<div class="camera-capture-wrapper">
    <!-- Hidden input that will be updated with the photo path -->
    <input type="hidden" wire:model="photoPath" id="photo-path-input">
    
    <div class="mb-4 space-y-4">
        <!-- Camera control buttons -->
        <div class="flex space-x-2">
            <button 
                type="button"
                wire:click="toggleCamera"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                {{ $cameraActive ? 'Close Camera' : 'Open Camera' }}
            </button>
            
            @if ($cameraActive)
                <button 
                    type="button"
                    wire:click="toggleFlash"
                    class="px-4 py-2 text-sm font-medium text-white {{ $flashActive ? 'bg-yellow-500' : 'bg-gray-600' }} rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                >
                    {{ $flashActive ? 'Flash On' : 'Flash Off' }}
                </button>
            @endif
            
            @if ($photoDataUrl)
                <button 
                    type="button"
                    wire:click="retakePhoto"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    Retake Photo
                </button>
                
                <button 
                    type="button"
                    wire:click="savePhoto"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                    Save Photo
                </button>
            @endif
        </div>
        
        <!-- Camera device selector -->
        <div id="camera-devices-container" class="{{ $cameraActive ? 'block' : 'hidden' }} mb-4">
            <label class="block text-sm font-medium text-gray-700">Camera Device</label>
            <select id="camera-devices" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <!-- Will be populated with JavaScript -->
            </select>
        </div>
        
        <!-- Camera video display -->
        <div id="camera-container" class="{{ $cameraActive ? 'block' : 'hidden' }} relative">
            <video 
                id="camera-feed" 
                class="w-full max-w-md h-auto border-2 border-gray-300 rounded-lg" 
                autoplay playsinline
            ></video>
            
            <button 
                type="button"
                id="capture-btn"
                class="absolute bottom-4 left-1/2 transform -translate-x-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
            >
                Capture
            </button>
        </div>
        
        <!-- Preview captured photo -->
        @if ($photoDataUrl)
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">Preview:</h4>
                <img src="{{ $photoDataUrl }}" class="mt-1 max-w-md border-2 border-gray-300 rounded-lg">
            </div>
        @elseif ($photoPath)
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">Saved Photo:</h4>
                <img src="{{ asset('storage/' . $photoPath) }}" class="mt-1 max-w-md border-2 border-gray-300 rounded-lg">
            </div>
        @endif
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            let stream = null;
            let videoElement = document.getElementById('camera-feed');
            let captureButton = document.getElementById('capture-btn');
            let devicesSelect = document.getElementById('camera-devices');
            
            @this.on('photo-captured', (data) => {
                // Update the hidden input in the parent Filament form
                const formComponentId = data.formComponentId;
                
                // Multiple ways to target the hidden input for maximum reliability
                // 1. Try targeting by form component ID
                let hiddenInput = null;
                
                if (formComponentId) {
                    // Try to find the input specifically in the form component
                    hiddenInput = document.querySelector(`[name="data[photo_path]"], [data-field-name="photo_path"], #${formComponentId}`);
                }
                
                // 2. If not found, try a more general approach
                if (!hiddenInput) {
                    hiddenInput = document.querySelector('input[name="photo_path"], [name="data[photo_path]"], [data-field-name="photo_path"]');
                }
                
                // 3. Find input by Livewire binding to photo_path
                if (!hiddenInput) {
                    const allInputs = document.querySelectorAll('input[type="hidden"]');
                    for (const input of allInputs) {
                        if (input.getAttribute('wire:model') === 'photo_path' || 
                            input.getAttribute('wire:model.defer') === 'photo_path') {
                            hiddenInput = input;
                            break;
                        }
                    }
                }
                
                if (hiddenInput) {
                    // Update the value
                    hiddenInput.value = data.path;
                    
                    // Dispatch events to ensure Filament and browser detect the change
                    hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                    hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    console.log('Updated hidden input with photo path:', data.path);
                } else {
                    console.warn('Could not find hidden input field for photo_path');
                    
                    // As a last resort, use a custom event that we can listen for elsewhere
                    document.dispatchEvent(new CustomEvent('camera-photo-saved', { 
                        detail: { path: data.path } 
                    }));
                }
                
                // Also dispatch a global event for any other listeners
                window.dispatchEvent(new CustomEvent('filament-camera-photo-saved', { 
                    detail: { path: data.path } 
                }));
            });
            
            // Initialize camera when toggled on
            @this.watch('cameraActive', (active) => {
                if (active) {
                    initializeCamera();
                } else {
                    stopCamera();
                }
            });
            
            // Handle flash toggle
            @this.watch('flashActive', (active) => {
                toggleFlash(active);
            });
            
            // Initialize camera
            async function initializeCamera() {
                try {
                    // First get available devices
                    const devices = await navigator.mediaDevices.enumerateDevices();
                    const videoDevices = devices.filter(device => device.kind === 'videoinput');
                    
                    // Populate the device selector
                    devicesSelect.innerHTML = '';
                    videoDevices.forEach(device => {
                        const option = document.createElement('option');
                        option.value = device.deviceId;
                        option.text = device.label || `Camera ${devicesSelect.options.length + 1}`;
                        devicesSelect.appendChild(option);
                    });
                    
                    // Use the selected device or the first one
                    const deviceId = @this.selectedDeviceId || (videoDevices.length > 0 ? videoDevices[0].deviceId : null);
                    
                    // Get access to camera
                    const constraints = {
                        video: {
                            deviceId: deviceId ? { exact: deviceId } : undefined,
                            facingMode: { ideal: 'environment' },
                        }
                    };
                    
                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                    videoElement.srcObject = stream;
                    
                    // Update selected device
                    if (deviceId) {
                        @this.selectedDeviceId = deviceId;
                        devicesSelect.value = deviceId;
                    }
                    
                    // Handle device change
                    devicesSelect.addEventListener('change', (e) => {
                        @this.selectedDeviceId = e.target.value;
                        stopCamera();
                        initializeCamera();
                    });
                    
                    // Handle capture button
                    captureButton.addEventListener('click', captureImage);
                    
                } catch (err) {
                    console.error('Error accessing camera:', err);
                    alert('Error accessing camera: ' + err.message);
                    @this.cameraActive = false;
                }
            }
            
            // Capture image from video
            function captureImage() {
                if (!videoElement.srcObject) return;
                
                const canvas = document.createElement('canvas');
                canvas.width = videoElement.videoWidth;
                canvas.height = videoElement.videoHeight;
                
                const ctx = canvas.getContext('2d');
                ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
                
                // Convert to data URL
                const dataUrl = canvas.toDataURL('image/jpeg', 0.95);
                
                // Send to Livewire component
                @this.capturePhoto(dataUrl);
            }
            
            // Toggle flash/torch
            async function toggleFlash(active) {
                if (!stream) return;
                
                const track = stream.getVideoTracks()[0];
                
                if (track && typeof track.getCapabilities === 'function') {
                    const capabilities = track.getCapabilities();
                    
                    // Check if torch is supported
                    if (capabilities.torch) {
                        try {
                            await track.applyConstraints({
                                advanced: [{ torch: active }]
                            });
                        } catch (err) {
                            console.error('Error toggling flash:', err);
                        }
                    } else {
                        console.warn('Torch/flash not supported on this device');
                    }
                }
            }
            
            // Stop camera
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                    videoElement.srcObject = null;
                }
            }
        });
    </script>
</div>