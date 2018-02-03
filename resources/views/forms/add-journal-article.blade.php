<form id="addJournalArticleID" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
						
                        <!-- {{ csrf_field() }} -->

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Название*</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('authors') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Авторы*</label>

                            <div class="col-md-6">
                                <input id="authors" type="text" class="form-control" name="authors" value="" >
								

                                @if ($errors->has('authors'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('authors') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('abstract') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Абстракт</label>

                            <div class="col-md-6">
                                <!--<input id="abstract" type="text" class="form-control" name="abstract" value="" required autofocus>-->
                                <textarea id="abstract" class="form-control" name="abstract" autofocus></textarea>

                                @if ($errors->has('abstract'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('abstract') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('journal_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Журнал*</label>

                            <div class="col-md-6">
                                <input id="journal_id" type="text" class="form-control" name="journal_id" value="" required autofocus>

                                @if ($errors->has('journal_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('journal_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Год</label>

                            <div class="col-md-6">
                                <input id="year" type="text" class="form-control" name="year" value="" autofocus>

                                @if ($errors->has('year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('volume') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Volume</label>

                            <div class="col-md-6">
                                <input id="volume" type="text" class="form-control" name="volume" value="" autofocus>

                                @if ($errors->has('volume'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('volume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('issue') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Issue</label>

                            <div class="col-md-6">
                                <input id="issue" type="text" class="form-control" name="issue" value="" autofocus>

                                @if ($errors->has('issue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('issue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('pages') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Pages</label>

                            <div class="col-md-6">
                                <input id="pages" type="text" class="form-control" name="pages" value="" autofocus>

                                @if ($errors->has('pages'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pages') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('ArXivID') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">ArXivID</label>

                            <div class="col-md-6">
                                <input id="ArXivID" type="text" class="form-control" name="ArXivID" value="" autofocus>

                                @if ($errors->has('ArXivID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ArXivID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="form-group{{ $errors->has('DOI') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">DOI</label>

                            <div class="col-md-6">
                                <input id="DOI" type="text" class="form-control" name="DOI" value="" autofocus>

                                @if ($errors->has('DOI'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('DOI') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('PMID') ? ' has-error' : '' }}">
                            <label for="PMID" class="col-md-4 control-label">PMID</label>

                            <div class="col-md-6">
                                <input id="PMID" type="text" class="form-control" name="PMID" value="" autofocus>

                                @if ($errors->has('PMID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PMID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('filepath') ? ' has-error' : '' }}">
                            <label for="filepath" class="col-md-4 control-label">Загрузить файл<br>(Только PDF файлы размером не более 1 Мб)</label>

                            <div class="col-md-6">
                                <input id="filepath" type="file" class="form-control" name="filepath" value="" autofocus>

                                @if ($errors->has('filepath'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('filepath') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="uid" id="uid" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="folder" id="folder" value='0'>


						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Добавить статью
                                </button>
                                <input type="reset" value="Очистить поля"/>
                            </div>
                        </div>
                    </form>