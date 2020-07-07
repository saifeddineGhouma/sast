@extends('front/layouts/master')

@section('meta')
	<title>طلب إنضمام</title>
@stop
@section("styles")

@stop

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media">
                <nav aria-label="breadcrumb">
                    <p >
                    	نبذة عن المجلس
                    	<br>
						المجلس العالمي للعلوم الرياضية في السويد GCSS هي مؤسسة رياضية تثقيفية تاسست في السويد منذ عام 2014 من قبل بعض الخبراء الدوليين والاساتذة الاكاديميين والمدربين وبمختلف التخصصات الرياضية وعلى اعلى المستويات. بدأنا بنشر الخبرات والمعارف الرياضية بمختلف مجالاتها الاكاديمية والتدريبية والمهنية   
						<br>
						كما عمل المجلس العالمي للعلوم الرياضية منذ تاسيسه على المضي قدماً ساعياً نشر رقعة المساحة المعرفية الرياضية في الجانبين العملي الميداني والنظري الاكاديمي .. من خلال الدعم العلمي لكل المؤسسات والمنظمات الرياضية التي تهتم برفع الواقع العلمي في الجانب البدني وبمختلف انواعه وتفرعاته و نحن منفتحين على كافة أشكال و طلبات التعاون سواء كانت من أفراد أو مؤسسات و لكن يبقى لدينا اسم المجلس هو الاهم في حساباتنا.. فنحن ملتزمون بمعايير الجودة العالمية من خلال المفوضية الاوروبية للتعليم.
						<br><br>
						تساهم هذه الأسئلة في مساعدتكم على تقديم طلبكم لذلك نرجو منكم الإجابة عليها بالتفصيل 
                    </p>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
			<div class="row">
			    <div class="row setup-content" id="step-1">
			        <div class="col-xs-12">
			            <div class="col-xs-12 well text-center">
			            	<form method="post" action="">
								<div class="col-xs-12 userlogedin text-right">
								    <div clas="form-group">
								        <label class="form-label">هل أنتم مؤسسة أم أفراد ؟ <span>*</span></label>
								        <select class="form-control" name="accreditation_type" id="accreditation_type">
								        	<option></option>
								        	<option value="مؤسسة">مؤسسة </option>
								        	<option value="افراد">افراد</option>
								        </select> 
										<br>
								    </div>
								    <div id="particular" style="display: none;">
									    <div clas="form-group">
									        <label class="form-label"> يرجى ارفاق السيرة الذاتية <span>*</span></label>
											 <input type="file" class="form-control" name="file_cv">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">هل سبق لكم العمل كمحاضر؟<span>*</span></label>
									        <select class="form-control" name="coach" id="accreditation_coach">
									        	<option></option>
									        	<option value="نعم">نعم</option>
									        	<option value="لا">لا</option>
									        </select> 
									        نعم . يرجى ارفاق بعض الدلائل *  :  <input type="file" name="file_coach">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">هل قمت بأعمال إدارية سابقة؟ <span>*</span></label>
									        <select class="form-control" name="admin" id="accreditation_admin">
									        	<option></option>
									        	<option value="نعم">نعم</option>
									        	<option value="لا">لا</option>
									        </select> 
									        نعم .فيما تتمثل؟ يرجى ارفاق بعض الدلائل *  :  <input type="file" name="file_admin">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">هل لديك شهادات معتمدة في المجال؟ <span>*</span></label>
									        <select class="form-control" name="experience" id="accreditation_experience">
									        	<option></option>
									        	<option value="نعم">نعم</option>
									        	<option value="لا">لا</option>
									        </select> 
									        نعم. يرجى ارفاق بعض الدلائل *  :  <input type="file" name="file_experience">
											<br>
									    </div>
									    نفضل أن تحصل على تزكية كتابية من شخصين معتمدين في المجال
									    <div clas="form-group">
									        <label class="form-label">الشخص الأول <span>*</span></label>
									        <input type="text" class="form-control" name="first_recommand" >
									        يرجى ارفاق سيرته الذاتية  :  <input type="file" name="cv_first_recommand">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> الشخص الثاني <span>*</span></label>
									        <input type="text" class="form-control" name="second_recommand" >
									        يرجى ارفاق سيرته الذاتية  :  <input type="file" name="cv_second_recommand">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> ماهي الخطة التسويقية التي تتبعونها؟ <span>*</span></label>
									        <textarea class="form-control" name="marketing_plan"></textarea>
									        يرجى ارفاق نموذج.  :  <input type="file" class="form-control" name="file_marketing_plan">
											<br>
									    </div>
									</div>
									<div id="company" style="display: none;">
									    <div clas="form-group">
									        <label class="form-label">يرجى ارفاق الملف الشخصي للمؤسسة <span>*</span></label>
											 <input type="file" class="form-control" name="file_company">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">موقع ويب <span>*</span></label>
											 <input type="text" class="form-control" name="website">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> ماهي الدورات  و المناهج التي تقدمونها؟ <span>*</span></label>
									        <textarea class="form-control" name="courses"></textarea>
									        يرجى ارفاق نماذج  :  <input type="file" class="form-control" name="file_courses">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> ماهي الدورات التي تطلبون الاعتماد فيها؟ <span>*</span></label>
									        <textarea class="form-control" name="accredited_courses"></textarea>
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> هل تقدمون دورات في مجالات غير متوفرة لدينا؟ <span>*</span></label>
									        <textarea class="form-control" name="other_courses"></textarea>
									        <input type="file" class="form-control" name="file_other_courses">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> ماهي الخطة التسويقية التي تتبعونها؟ <span>*</span></label>
									        <textarea class="form-control" name="c_marketing_plan"></textarea>
									        يرجى ارفاق نموذج.  :  <input type="file" name="file_c_marketing_plan">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> هل تم اعتماد  برامج مؤسستكم من قبل جهات محلية؟ <span>*</span></label>
									        <textarea class="form-control" name="other_accreditation"></textarea>
									        يرجى ارفاق بعض الدلائل  :  <input type="file" name="file_other_accreditation">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> هل تم اعتماد برامج مؤسستكم من قبل جهات عالمية؟ <span>*</span></label>
									        <textarea class="form-control" name="other_accreditation_world"></textarea>
									        يرجى ارفاق بعض الدلائل  :  <input type="file" name="file_other_accreditation_world">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> ما هو تقييم عملائكم للمادة التعليمية المقدمة؟ <span>*</span></label>
									        <textarea class="form-control" name="users_review"></textarea>
									        يرجى ارفاق بعض الدلائل  :  <input type="file" name="file_users_review">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label"> هل يتمتع المدربين بخبرات جيدة؟ <span>*</span></label>
									        <textarea class="form-control" name="coachs"></textarea>
									        يرجى ارفاق 3 سير ذاتية ل3 مدربين مختلفين على الأقل  <input type="file" name="file_coachs" multiple="multiple">
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">هل سبق لكم التعامل مع مراكز أو منظمات  أخرى  في دورات تدريبية؟ <span>*</span></label>
									        <textarea class="form-control" name="other_centers"></textarea>
											<br>
									    </div>
									    <div clas="form-group">
									        <label class="form-label">ما هو معدل الحضور في دوراتكم التدريبية؟و ما هي نسبة النجاح؟يرجى ارفاق دلائل <span>*</span></label>
											 <input type="file" class="form-control" name="other_infos" multiple="multiple">
											<br>
									    </div>
									</div>
								</div>
							</form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>		    

@stop

@section('scripts')
	<script type="text/javascript">
		$("#accreditation_type").change(function(){
			if(this.value == "مؤسسة"){
				$("#company").removeAttr('style');
				$("#particular").attr('style','display:none;');
			}
			if(this.value == "افراد"){
				$("#particular").removeAttr('style');
				$("#company").attr('style','display:none;');
			}
			
		});
	</script>
@stop
