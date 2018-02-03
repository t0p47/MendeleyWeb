<form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_user') }}" autocomplete="off">
                        {{ csrf_field() }}
						
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
						
						<div class="form-group">
							<label for="ip" class="col-md-4 control-label">IP mask:</label>

							<div class="input-group col-md-6">
							  <div class="input-group-addon">
								<i class="fa fa-laptop"></i>
							  </div>
								@if($ip_restrict=='yes')
									<input type="hidden" name="mass_restrict" value="01">
									<input class="form-control" data-inputmask="'alias': 'ip'" id="ip" data-mask="" name="ip" type="text" disabled placeholder="Disable mass ip restriction first">
								@else
									<input class="form-control" data-inputmask="'alias': 'ip'" id="ip" data-mask="" name="ip" type="text">
								@endif
							</div>
							<!-- /.input group -->
						  </div>
						  
						@if($ip_restrict=='no')
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<label for="ip_restrict" class="control-label">
									Enable IP restrict for this user?
								</label>
								<div class="icheckbox_flat-green input-group" style="position: relative;" aria-checked="false" aria-disabled="false">
									<input class="flat-red" checked="" name="ip_restrict" style="position: absolute; opacity: 0;" type="checkbox">
									
								</div>
							</div>
						  </div>
						@endif

						<input type="hidden" id="user_id" name="user_id" value="">
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit User
                                </button>
								
								<button onclick="event.preventDefault();
                                document.getElementById('delete-user').submit();" class="btn btn-danger pull-right">Delete User</button>
								
                            </div>
                        </div>
                    </form>
					<form class="pull-right" id="delete-user" action="" method="POST">
									
									{{method_field('DELETE')}}
									
									{{csrf_field()}}
									
									<!--<button type="submit" class="btn btn-danger pull-right">
										Delete User
									</button>-->
								</form>