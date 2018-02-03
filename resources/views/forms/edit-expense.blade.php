<form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_expense') }}" autocomplete="off">
                        {{ csrf_field() }}
						
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('details') ? ' has-error' : '' }}">
                            <label for="details" class="col-md-4 control-label">Details</label>

                            <div class="col-md-6">
                                <input id="details" type="text" class="form-control" name="details" value="{{ old('details') }}" required>

                                @if ($errors->has('details'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group">
							<label for="datepicker" class="col-md-4 control-label">Date:</label>

							<div class="input-group date col-md-6" data-provide="datepicker">
							  <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							  </div>
							  <input class="form-control pull-right" id="datepicker" type="text">
							</div>
							<!-- /.input group -->
						 </div>
						 
						
						<div class="bootstrap-timepicker col-md-8 col-md-offset-2"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a></td></tr><tr><td><span class="bootstrap-timepicker-hour">05</span></td> <td class="separator">:</td><td><span class="bootstrap-timepicker-minute">00</span></td> <td class="separator">&nbsp;</td><td><span class="bootstrap-timepicker-meridian">PM</span></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a></td></tr></tbody></table></div>
							<div class="form-group">
							  <label for="timepicker" class="col-md-4 control-label">Time picker:</label>

							  <div class="input-group">
								<input class="form-control timepicker" id="timepicker" type="text">

								<div class="input-group-addon">
								  <i class="fa fa-clock-o"></i>
								</div>
							  </div>
							  <!-- /.input group -->
							</div>
							<!-- /.form group -->
						  </div>
						
						
						
						<input type="hidden" name="id" id="id" value="">
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit expense
                                </button>
								
								<button onclick="event.preventDefault();
                                document.getElementById('delete-expense').submit();" class="btn btn-danger pull-right">Delete Expense</button>
								
                            </div>
                        </div>
                    </form>
					<form class="pull-right" id="delete-expense" action="" method="POST">
									
									{{method_field('DELETE')}}
									
									{{csrf_field()}}
								</form>