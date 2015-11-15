@extends ('admin.layouts.default')
@section('main')
<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">More Pages</a>
							</li>
							<li class="active">Inbox</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
					</div>

					<div class="page-content">
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select><div class="dropdown dropdown-colorpicker">		<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="btn-colorpicker" style="background-color:#438EB9"></span></a><ul class="dropdown-menu dropdown-caret"><li><a class="colorpick-btn selected" href="#" style="background-color:#438EB9;" data-color="#438EB9"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#222A2D;" data-color="#222A2D"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#C6487E;" data-color="#C6487E"></a></li><li><a class="colorpick-btn" href="#" style="background-color:#D0D0D0;" data-color="#D0D0D0"></a></li></ul></div>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar">
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar">
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs">
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl">
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container">
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover">
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact">
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight">
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->

						<div class="page-header">
							<h1>
								Inbox
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Mailbox with some customizations as described in docs
								</small>
							</h1>
						</div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="tabbable">
                                <ul class="inbox-tabs nav nav-tabs padding-16 tab-size-bigger tab-space-1" id="myTab">
                        			<li class="li-new-mail pull-right">
										<a data-toggle="tab" href="#write" data-target="write" class="btn-new-mail">
											<span class="btn btn-purple no-border">
												<i class="ace-icon fa fa-envelope bigger-130"></i>
												<span class="bigger-110">Write Mail</span>
											</span>
										</a>
									</li><!-- /.li-new-mail -->
                                    <li class="active">
                                        <a data-toggle="tab" href="#inbox" aria-expanded="false" onclick="inbox()"> 
                                            <i class="blue ace-icon fa fa-inbox bigger-130"></i>
                                            <span class="bigger-110">Inbox</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-4" aria-expanded="false">
											<i class="orange ace-icon fa fa-location-arrow bigger-130"></i>
											<span class="bigger-110">Sent</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#payment" aria-expanded="false">
											<i class="green ace-icon fa fa-pencil bigger-130"></i>
											<span class="bigger-110">Draft</span>
                                        </a>
                                    </li>
									<li class="dropdown">
										<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											<i class="pink ace-icon fa fa-tags bigger-130"></i>

											<span class="bigger-110">
												Tags
												<i class="ace-icon fa fa-caret-down"></i>
											</span>
										</a>

										<ul class="dropdown-menu dropdown-light-blue dropdown-125">
											<li>
												<a data-toggle="tab" href="#tag-1">
													<span class="mail-tag badge badge-pink"></span>
													<span class="pink">Tag#1</span>
												</a>
											</li>

											<li>
												<a data-toggle="tab" href="#tag-family">
													<span class="mail-tag badge badge-success"></span>
													<span class="green">Family</span>
												</a>
											</li>

											<li>
												<a data-toggle="tab" href="#tag-friends">
													<span class="mail-tag badge badge-info"></span>
													<span class="blue">Friends</span>
												</a>
											</li>

											<li>
												<a data-toggle="tab" href="#tag-work">
													<span class="mail-tag badge badge-grey"></span>
													<span class="grey">Work</span>
												</a>
											</li>
										</ul>
									</li><!-- /.dropdown -->

                                    <!-- /.dropdown -->
                                </ul>
                                <div class="message-container">
                                <div id="id-message-list-navbar" class="message-navbar clearfix">
									<div class="message-bar">
										<div class="message-infobar" id="id-message-infobar">
											<span class="blue bigger-150">Inbox</span>
											<span class="grey bigger-110">(2 unread messages)</span>
										</div>

										<div class="message-toolbar hide">
											<div class="inline position-relative align-left">
												<button type="button" class="btn-white btn-primary btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<span class="bigger-110">Action</span>

													<i class="ace-icon fa fa-caret-down icon-on-right"></i>
												</button>

												<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
													<li>
														<a href="#">
															<i class="ace-icon fa fa-mail-reply blue"></i>&nbsp; Reply
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-mail-forward green"></i>&nbsp; Forward
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-folder-open orange"></i>&nbsp; Archive
														</a>
													</li>

													<li class="divider"></li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-eye blue"></i>&nbsp; Mark as read
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-eye-slash green"></i>&nbsp; Mark unread
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-flag-o red"></i>&nbsp; Flag
														</a>
													</li>

													<li class="divider"></li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-trash-o red bigger-110"></i>&nbsp; Delete
														</a>
													</li>
												</ul>
											</div>

											<div class="inline position-relative align-left">
												<button type="button" class="btn-white btn-primary btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<i class="ace-icon fa fa-folder-o bigger-110 blue"></i>
													<span class="bigger-110">Move to</span>

													<i class="ace-icon fa fa-caret-down icon-on-right"></i>
												</button>

												<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
													<li>
														<a href="#">
															<i class="ace-icon fa fa-stop pink2"></i>&nbsp; Tag#1
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-stop blue"></i>&nbsp; Family
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-stop green"></i>&nbsp; Friends
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-stop grey"></i>&nbsp; Work
														</a>
													</li>
												</ul>
											</div>

											<button type="button" class="btn btn-xs btn-white btn-primary">
												<i class="ace-icon fa fa-trash-o bigger-125 orange"></i>
												<span class="bigger-110">Delete</span>
											</button>
										</div>
									</div>

									<div>
										<div class="messagebar-item-left">
											<label class="inline middle">
												<input type="checkbox" id="id-toggle-all" class="ace">
												<span class="lbl"></span>
											</label>

											&nbsp;
											<div class="inline position-relative">
												<a href="#" data-toggle="dropdown" class="dropdown-toggle">
													<i class="ace-icon fa fa-caret-down bigger-125 middle"></i>
												</a>

												<ul class="dropdown-menu dropdown-lighter dropdown-100">
													<li>
														<a id="id-select-message-all" href="#">All</a>
													</li>

													<li>
														<a id="id-select-message-none" href="#">None</a>
													</li>

													<li class="divider"></li>

													<li>
														<a id="id-select-message-unread" href="#">Unread</a>
													</li>

													<li>
														<a id="id-select-message-read" href="#">Read</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="messagebar-item-right">
											<div class="inline position-relative">
												<a href="#" data-toggle="dropdown" class="dropdown-toggle">
													Sort &nbsp;
													<i class="ace-icon fa fa-caret-down bigger-125"></i>
												</a>

												<ul class="dropdown-menu dropdown-lighter dropdown-menu-right dropdown-100">
													<li>
														<a href="#">
															<i class="ace-icon fa fa-check green"></i>
															Date
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-check invisible"></i>
															From
														</a>
													</li>

													<li>
														<a href="#">
															<i class="ace-icon fa fa-check invisible"></i>
															Subject
														</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="nav-search minimized">
											<form class="form-search">
												<span class="input-icon">
													<input type="text" autocomplete="off" class="input-small nav-search-input" placeholder="Search inbox ...">
													<i class="ace-icon fa fa-search nav-search-icon"></i>
												</span>
											</form>
										</div>
									</div>
								</div>
                                </div>

                                <div class="tab-content no-border padding-24">
                                   <div id="inbox" class="tab-pane fade active in">
                                        <h4 class="blue"></h4>
                                        <div class="space-8"></div>
                                        <div id="inboxMail" class="panel-group accordion-style1 accordion-style2">
								            <div class="message-item message-unread">
												<label class="inline">
													<input type="checkbox" class="ace">
													<span class="lbl"></span>
												</label>

												<i class="message-star ace-icon fa fa-star orange2"></i>
												<span class="sender" title="Alex John Red Smith">Alex John Red Smith </span>
												<div id="responsecontainer" align="center">
												<tbody>
												</tbody>

												</div>
												<span class="time">1:33 pm</span>

												<span class="summary">
													<span class="text">
														Click to open this message
													</span>
												</span>
											</div>

                                       </div>
                                   </div>
								</div><!-- /.page-content -->
							</div>
						</div>
					</div>


<script type="text/javascript">
$('#inbox').ready(function(){
$.ajax(
   {
      type:'GET',
      url:'/inbox',
      data:'',
      success: function(data){
        $.each(data, function(index, value) {
        				$('.sender').remove();
        				var trHTML = value.from_mail

                        $('#responsecontainer tbody').remove();
                         var trHTML = '';
                         trHTML += '<tr><td>' + value.message_id + '</td><td>' + value.history_id  + '</td><td>' + value.subject + '</tr></td>' ;

                    $('#responsecontainer').append(trHTML);
		});
      }
   }
);
});
</script>


@stop				