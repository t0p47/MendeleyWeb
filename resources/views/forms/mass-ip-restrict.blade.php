					<form class="form-horizontal" role="form" method="POST" action="{{ url('/mass_ip_restrict') }}" autocomplete="off">
                        {{ csrf_field() }}
						
						<input type="hidden" name="ip_restrict" value="yes">
						
						<div class="form-group">
							<label for="ip" class="col-md-4 control-label">IP for all users:</label>

							<div class="input-group col-md-6">
							  <div class="input-group-addon">
								<i class="fa fa-laptop"></i>
							  </div>
							  <input class="form-control" data-inputmask="'alias': 'ip'" id="ip" data-mask="" name="ip" type="text" value="{{$admin->ip}}">
							</div>
							<!-- /.input group -->
						  </div>
						  
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Enable ip restrict
                                </button>
								
                            </div>
                        </div>
                    </form>