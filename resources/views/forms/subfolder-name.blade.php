<form class="form-horizontal" role="form" method="POST" action="{{ route('addJournalArticle') }}" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}
						
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Название</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="isrename" id="isrename" value='0'>
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Добавить статью(Заменить)
                                </button>
                            </div>
                        </div>
                    </form>