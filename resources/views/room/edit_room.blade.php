@extends('admin.admin_dashboard')
@section('admin')

@php
    $pageTitle = 'Room'
@endphp
<div class="page-content">
	{{ Breadcrumbs::render('edit_room', $room->id) }}
                <div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Edit Room</h6>
									<form method="POST" action="{{route('updateroom', $room->id)}}" class="form-sample">
                                        @csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Name</label>
													<input type="text" class="form-control @error('room_name') is-invalid @enderror" id="name" name="room_name" value="{{old('room_name', $room->name)}}">
													@error('room_name')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Block</label>
													<input type="text" class="form-control @error('room_block') is-invalid @enderror" id="block" name="room_block" value="{{old('room_block', $room->block)}}">
													@error('room_block')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Floor</label>
													<input type="text" class="form-control @error('room_floor') is-invalid @enderror" id="floor" name="room_floor" value="{{old('room_floor', $room->floor)}}">
													@error('room_floor')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">House</label>
													<input type="text" class="form-control @error('room_house') is-invalid @enderror" id="house" name="room_house" value="{{old('room_house', $room->house)}}">
													@error('room_house')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
                                        <div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Room</label>
													<input type="text" class="form-control @error('room_room') is-invalid @enderror" id="room" name="room_room" value="{{old('room_room', $room->room)}}">
													@error('room_room')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Type</label>
													<input type="text" class="form-control @error('room_type') is-invalid @enderror" id="type" name="room_type" value="{{old('room_type', $room->type)}}">
													@error('room_type')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
                                        <div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Capacity</label>
													<input type="number" class="form-control @error('room_capacity') is-invalid @enderror" id="capacity" name="room_capacity" value="{{old('room_capacity', $room->capacity)}}">
													@error('room_capacity')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Status</label>
													<div class="col-sm-12">
														<select class="form-select @error('room_status') is-invalid @enderror" id="roomStatus" name="room_status">
															<option selected disabled>Status</option>
															<option value="Available" {{ $room->status =='available'?'selected':''}}>Available</option>
															<option value="Unavailable" {{ $room->status =='unavailable'?'selected':''}}>Unavailable</option>
														</select>
														@error('room_status')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
													</div>
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Occupy</label>
													<input type="number" class="form-control @error('room_occupy') is-invalid @enderror" id="capacity" name="room_occupy" value="{{old('room_occupy',$room->capacity)}}">
													@error('room_occupy')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
                                        <div class="row">
											<div class="col-sm-12">
												<div class="mb-3">
													<label class="form-label">Remark</label>
													<textarea class="form-control @error('room_remark') is-invalid @enderror" rows="3" name="room_remark" placeholder="Remark">{{old('room_remark', $room->remark)}}</textarea>
													@error('room_remark')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="d-flex justify-content-end gap-2">
											<button type="submit" class="btn btn-primary submit">Update</button>
										</div>
									</form>
							</div>
						</div>
					</div>
				</div>
            </div>

			<script>
				function updateRoomName() {
					const block = document.getElementById('block').value.toUpperCase();
					const floor = document.getElementById('floor').value.toUpperCase();
					const house = document.getElementById('house').value.padStart(2, '0');
					const room = document.getElementById('room').value.toUpperCase();
			
					if (block && floor && house && room) {
						const name = `${block}${floor}/${house}/${room}`;
						document.getElementById('name').value = name;
					}
				}
			
				document.getElementById('block').addEventListener('input', updateRoomName);
				document.getElementById('floor').addEventListener('input', updateRoomName);
				document.getElementById('house').addEventListener('input', updateRoomName);
				document.getElementById('room').addEventListener('input', updateRoomName);
			</script>
			
@endsection