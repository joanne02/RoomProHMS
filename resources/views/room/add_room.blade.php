@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Room'
@endphp

<div class="page-content">
    {{ Breadcrumbs::render('add_room') }}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Add Room</h6>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('storeroom') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label class="form-label">Block</label>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">From</label>
                            <div class="col-sm-8">
                                <input type="text" name="block_from" class="form-control @error('block_from') is-invalid @enderror">
                                @error('block_from')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">To</label>
                            <div class="col-sm-8 mt-2">
                                <input type="text" name="block_to" class="form-control @error('block_to') is-invalid @enderror">
                                @error('block_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label class="form-label">Floor</label>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">From</label>
                            <div class="col-sm-8">
                                <input type="text" name="floor_from" class="form-control @error('floor_from') is-invalid @enderror">
                                @error('floor_from')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">To</label>
                            <div class="col-sm-8 mt-2">
                                <input type="text" name="floor_to" class="form-control @error('floor_to') is-invalid @enderror">
                                @error('floor_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label class="form-label">House</label>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">From</label>
                            <div class="col-sm-8">
                                <input type="text" name="house_from" class="form-control @error('house_from') is-invalid @enderror">
                                @error('house_from')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">To</label>
                            <div class="col-sm-8 mt-2">
                                <input type="text" name="house_to" class="form-control @error('house_to') is-invalid @enderror">
                                @error('house_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Room Types Section -->
            <div class="row mb-3">
                <div class="row">
                    <label class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-6">
                        <button type="button" id="add-room-type" class="btn btn-secondary mt-2">Add Room Type</button>
                    </div>
                </div>
                {{-- <label class="col-sm-4 mb-3">Room Types</label> --}}
                <div id="room-types-container">
                    <div class="room-type-entry row mt-2">
                        @php
                            $roomTypes = old('room_types');
                        @endphp

                        @if (!empty($roomTypes))
                            @foreach ($roomTypes as $index => $roomType)
                                <div class="room-type-entry row mt-2">
                                    <div class="col-md-4">
                                        <input type="text"
                                            name="room_types[{{ $index }}][letter]"
                                            value="{{ $roomType['letter'] ?? '' }}"
                                            class="form-control @error('room_types.' . $index . '.letter') is-invalid @enderror"
                                            placeholder="Room Letter (A, B, C)">
                                        @error('room_types.' . $index . '.letter')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"
                                            name="room_types[{{ $index }}][type]"
                                            value="{{ $roomType['type'] ?? '' }}"
                                            class="form-control @error('room_types.' . $index . '.type') is-invalid @enderror"
                                            placeholder="Room Type (Single, Double)">
                                        @error('room_types.' . $index . '.type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number"
                                            name="room_types[{{ $index }}][capacity]"
                                            value="{{ $roomType['capacity'] ?? '' }}"
                                            class="form-control @error('room_types.' . $index . '.capacity') is-invalid @enderror"
                                            placeholder="Capacity">
                                        @error('room_types.' . $index . '.capacity')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-room-type">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Default empty row if no old input --}}
                            {{-- <div class="room-type-entry row mt-2"> --}}
                                <div class="col-md-4">
                                    <input type="text" name="room_types[0][letter]" class="form-control" placeholder="Room Letter (A, B, C)">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="room_types[0][type]" class="form-control" placeholder="Room Type (Single, Double)">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="room_types[0][capacity]" class="form-control" placeholder="Capacity">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-room-type">Delete</button>
                                </div>
                            {{-- </div> --}}
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Gender</label>
                <div class="col-md-4">
                    <select class="form-select @error('room_gender') is-invalid @enderror" id="roomGender" name="room_gender">       
                        <option selected disabled>Select Gender</option>    
                        <option value="male">Male</option> 
                        <option value="female">Female</option> 
                    </select>
                    @error('room_gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Generate Rooms</button>
        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let index = 1;

        // Add Room Type dynamically
        document.getElementById("add-room-type").addEventListener("click", function () {
            let container = document.getElementById("room-types-container");
            let newEntry = document.createElement("div");
            newEntry.classList.add("room-type-entry", "row", "mt-2");

            newEntry.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="room_types[${index}][letter]" class="form-control" placeholder="Room Letter (A, B, C)">
                </div>
                <div class="col-md-4">
                    <input type="text" name="room_types[${index}][type]" class="form-control" placeholder="Room Type (Single, Double)">
                </div>
                <div class="col-md-3">
                    <input type="number" name="room_types[${index}][capacity]" class="form-control" placeholder="Capacity">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-room-type">Delete</button>
                </div>
            `;

            container.appendChild(newEntry);
            index++;
        });

        // Remove Room Type
        document.getElementById("room-types-container").addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-room-type")) {
                event.target.closest(".room-type-entry").remove();
            }
        });

        
        document.querySelector('form').addEventListener('submit', function (e) {
        const isValid = validateRoomTypes();
        if (!isValid) {
            e.preventDefault(); // Stop form submission
        }
        });
    });

    function validateRoomTypes() {
        let isValid = true;

        // Select all room type groups
        const roomLetters = document.querySelectorAll('input[name^="room_types"][name$="[letter]"]');
        const roomTypes = document.querySelectorAll('input[name^="room_types"][name$="[type]"]');
        const roomCapacities = document.querySelectorAll('input[name^="room_types"][name$="[capacity]"]');

        // Loop through each group of inputs
        for (let i = 0; i < roomLetters.length; i++) {
            const letter = roomLetters[i];
            const type = roomTypes[i];
            const capacity = roomCapacities[i];

            // Clear previous error styles
            [letter, type, capacity].forEach(input => input.classList.remove('is-invalid'));

            // Validate letter (e.g., A, B, C)
            if (!/^[A-Z]$/.test(letter.value.trim())) {
                letter.classList.add('is-invalid');
                isValid = false;
            }

            // Validate type (not empty)
            if (type.value.trim() === '') {
                type.classList.add('is-invalid');
                isValid = false;
            }

            // Validate capacity (positive number)
            const capVal = parseInt(capacity.value.trim());
            if (isNaN(capVal) || capVal <= 0) {
                capacity.classList.add('is-invalid');
                isValid = false;
            }
        }

        return isValid;
    }

</script>

@endsection
