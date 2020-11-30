// JavaScript Document

$(document).ready(function(){
	
	"use strict";
	

	$(document).on('click', '.actions .add', function(){
		
		var page = $(this).val();

		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			"page"	:	page
		};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/"+page.toLowerCase()+"/form.php",
			data		:	data,
			success 	: 	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
								
							},
			error		:	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");

			}
		});	

	});	
	
	$(document).on('click', '.save_form', function(){

		var selector = $(this).attr("data-table");
		console.log(selector + " table");
		var columns = {};
		var success = true;
		
		var selected = [];
		var tag;
		
		$("."+selector).find(".form-element").each(function(){
			
			if( $(this).hasClass("required") ){
				if($(this).val() === "" || $(this).val() === "-1"){
					$(this).addClass("error");
					success = false;
				}else{
					$(this).removeClass("error");
					columns[$(this).attr("id")] = $(this).val();
				}
			}else{
				if($(this).hasClass("on_off")){
					columns[$(this).attr("id")] = $(this).hasClass("on")? 1 : 0;
				}else{
					
					if($(this).hasClass("collection")){
						if($(this).is(':checked')){
							selected.push($(this).attr('value'));
							tag = $(this).attr("data-table");
							
						}
					}else{
						columns[$(this).attr("id")] = $(this).val();
					}
					
					if(selected.length>0){
						columns[tag] = selected;
					}	
	
				}		
			}

		});
		
		if($("#id").length > 0){
			columns.id = $("#id").val();
		}
		
		var data = {
			't_n'		:	selector,
			'columns'	:	columns
		};
		
		
		if(success){
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/"+selector.toLowerCase()+"/save.php",
				data		:	data,
				success 	: 	function(response){
					$(".modal").removeClass("show");
					if(response === "1"){

						swal("SUCCESS!", "L'élement' a été ajouté!", "success");
						var data = {
							"page"	:	"menu",
							"p"		:	{
								"s"		:	0,
								"pp"	:	50
							}
						};

						$.ajax({

							type		: 	"POST",
							url			: 	"pages/default/includes/" + selector.toLowerCase() + ".php",
							data		:	data,
							success 	: 	function(response){
												$('.content').html(response);
												$(".modal").removeClass("show");
											},
							error		:	function(response){
												$(".debug").html("Error : " + response);
												$(".modal").removeClass("show");

							}
						});
					}else{
						$(".debug").html("Error : " + response);
					}

				},
				error		:	function(response){
									$('.debug').html("Error : " + response);
									$(".modal").removeClass("show");
				}
			});
		}
	});

	$(document).on('click', '.edit_ligne', function(){

		var page = $(this).attr('data-page');

		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		var id = 0;
		
		if($(this).hasClass("btn")){
			id = $(this).val();
		}else{
			id = $(this).find(".id-ligne").html();
		}
		
		var data = {
			"page"		:	page,
			"id"		:	id
		};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/"+page.toLowerCase()+"/form.php",
			data		:	data,
			success 	: 	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
								
							},
			error		:	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");

			}
		});	


	});	

	$(document).on('click', '.remove_ligne', function(e){
		e.stopImmediatePropagation();
		
		var _this = $(this);
		var page = _this.attr('data-page');
		console.log(page);
		swal({
			  title: "Vous êtes sûr?",
			  text: "Êtes vous sûr de vouloir supprimer cette ligne? " + page.toLowerCase(),
				type:"warning",
				showCancelButton:!0,
				confirmButtonColor:"#3085d6",
				cancelButtonColor:"#d33",
				confirmButtonText:"Oui, Supprimer!"
			}).then(function(t){
			  if (t.value) {

					$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
					var id = _this.val();

					var data = {
						"page"		:	page,
						"id"		:	id
					};
				  page = page.toLowerCase();
					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/ajax/" + page + "/delete.php",
						data		:	data,
						success 	: 	function(response){
											if(response === "1"){
												if(_this.hasClass("and_exit")){
													$(".actions .close").addClass("dont-ask-for-permission");
													$(".actions .close").trigger("click");
												}else{
													$(".refresh").trigger("click");	
												}
													
											}else{
												$(".content").append('<div class="loading" style="position:fixed; z-index: 9999999; width: 100%; top: 0px;"><div style="margin: 10px auto; width: 350px" class="animated bounce"><div style="background-color:red; color:white" class="info info-success info-dismissible"> <div class="info-message"> '+response+' </div> <span class="close" data-dismiss="info" aria-label="close">&times;</span></div> 	</div></div>');
											}
											//alert(response);
											//$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});	


			  } else {

			  }
		});		
	});	

	$(document).on('click', '.edit_ligne_', function(){

		var page = $(this).attr('data-page');

		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		var id = 0;
		
		if($(this).hasClass("btn")){
			id = $(this).val();
		}else{
			id = $(this).find(".id-ligne").html();
		}
		
		var data = {
			"page"		:	page,
			"id"		:	id
		};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/"+page.toLowerCase()+"/form_edit.php",
			data		:	data,
			success 	: 	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
								
							},
			error		:	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");

			}
		});	


	});	

	
	/***************************
			SAVE EDIT OR NEW
	****************************/
	
	
	
	
	/****************************
			GENERALS
	*****************************/
	
	
	$(document).on("click", ".actions .close", function(){
		var page = $(this).val().toLowerCase();
		
		if($(this).hasClass("dont-ask-for-permission")){
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			var data = {
				"page"	:	page,
				"p"		:	{
					"s"		:	0,
					"pp"	:	50
				}
			};

			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/includes/"+page+".php",
				data		:	data,
				success 	: 	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
		}else{
			swal({
				title:"Êtes vous sûr?",
				text:"Si vous annuller, Vous perdez toutes les informations saisies!",
				type:"warning",
				showCancelButton:!0,
				confirmButtonColor:"#3085d6",
				cancelButtonColor:"#d33",
				confirmButtonText:"Oui, Quitter!"

				}).then(function(t){
				if(t.value){
					$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
					var data = {
						"page"	:	page,
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/"+page+".php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});
				}
			});				
		}
		
	
	});	
	
	$(document).on('click', '._close', function(){
		$(".modal").removeClass("show").html("");
	});
	
	$(document).on('click','.on_off',function(){ 
	
		if($(this).hasClass("on")){
			$(this).removeClass("on").addClass("off");
		}else{
			$(this).removeClass("off").addClass("on");
		}
	
	});

	$(document).on('click','.star_on_off',function(){ 
		
		$(this).find(".on").toggleClass("hide");
		$(this).find(".off").toggleClass("hide");
		
	
	});
	
	/***************************
			SEARCH
	***************************/	
	
	$(document).on("click", "#a_u_s", function(){
		if($(this).hasClass("_propriete")){
			if($("#request").val() === ""){
				$("._choices ." + $(this).attr("data")).remove();
			}else{
				$("._choices ." + $(this).attr("data")).remove();
				$("._choices").append('<span class="label label-blue '+$(this).attr("data")+'" style="margin-right:7px">'+$("#request").val()+'</span>');
			}			
		}
		$(".refresh").trigger('click');
	});
	
	$(document).on("keyup", "#request",function(e) {
		if(e.keyCode === 13 ) {
			
			$(".refresh").trigger('click');
		}
	});
	
	$(document).on("change", "._select select",function() {

		if($(this).val() === "-1"){
			$("._choices ." + $(this).attr("data")).remove();
		}else{
			$("._choices ." + $(this).attr("data")).remove();
			$("._choices").append('<span class="label label-blue '+$(this).attr("data")+'" style="margin-right:7px">'+$(this).find('option:selected').text()+'</span>');
		}
		$(".refresh").trigger('click');
		
	});
	
	/***************************
			REFRECH / ACTUALISER
	***************************/
	
	$(document).on('change', '#showPerPage', function(){
		$(".p_p").html($("#showPerPage").val());
		$(".current").html(0);
		$(".refresh").trigger('click');
	});
	
	$(document).on('click',"#btn_passive_next", function(){
		
		var current = $(".current").html();
		$(".current").html(parseInt(current)+1);
		$(".refresh").trigger('click');

				
	});
	
	$(document).on('click', "#btn_passive_preview", function(){
		
		var current = $(".current").html();
		if(current > 0){
			$(".current").html(parseInt(current)-1);
			$(".refresh").trigger('click');
			
		}
				
	});	
	
	$(document).on("click",".showSearchBar", function(){
		$(".searchBar").toggleClass("hide");
	});

	/*********** SORT BY COLUMNS 	***/
	
	$(document).on("click", ".sort_by", function(){
		
		var sort_by = $(this).attr("data-sort");
		
		if($("#sort_by").hasClass("desc")){
			
			$("#sort_by").removeClass("desc");
			$("#sort_by").addClass("asc");
			$("#sort_by").html(sort_by + " asc");
			
		}else{
			
			$("#sort_by").removeClass("asc");
			$("#sort_by").addClass("desc");
			$("#sort_by").html(sort_by + " desc");		
			
		}
		
		$(".refresh").trigger('click');
		
	});	
	
	$(document).on('click', ".style .btn", function(){
		$(".refresh").trigger('click');				
	});	
	
	$(document).on('click','.refresh',function(e){
		
		e.preventDefault();
		
		var current = $(".current").html();
		var pearPage = $("#showPerPage").val();
		var sort_by = $("#sort_by").html();
		var request = $("#request").val();
		
		var style = $(".btn-group-radio.style").find(".checked").val();
		var data = {
				't_n' : $(this).val(),
				'current'	:	current,
				'p_p'		:	pearPage,
				'sort_by'	:	sort_by,
				'request'	:	request,
				'style'		:	style
			};

		var filter = {};
		$("._select select").each(
			function(){
				if($(this).val() !== "-1"){
					filter[$(this).attr("data")] = $(this).val();
				}

			}
		);
		if(Object.keys(filter).length > 0 ){
			data.filter = filter;
		}

		var tag = $(this).val().toLocaleLowerCase();
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		$("."+tag).html("");

		$.post("pages/default/ajax/"+tag+"/get.php",{'data':data},function(response){
			$("."+tag).html(response);
			$(".modal").removeClass("show");
			
		});

	});
	
	// SHOW VERTICAL MENU
	$(".show_vertical_menu").on("click", function(){
		
		if ($(".vertical_menu").hasClass("toLeft")){
			
			$(".vertical_menu").animate({
				marginLeft: '0px'
			},500);
			
			$(".vertical_menu").removeClass("toLeft");	
			$(this).addClass("selected");
			
		}else{
			
			$(".vertical_menu").animate({
				marginLeft: '-=350px'
			},500);
			
			$(".vertical_menu").addClass("toLeft");	
			$(this).removeClass("selected");
		}
		
	});

	// SHOW SUB MENU
	$(".show_submenu").on("click", function(e){
		if(e.target !== this) {return;}
		$(this).find(".sub_menu").toggleClass("hide");
	});
	
	// OPEN CLICKED PAGE
	$(".open").on("click", function(){
		var page = $(this).find('.url').html();
		page = (page === "")? "index": page;
		$(".vertical_menu ul li").removeClass("selected");
		parent.location.hash = page;
		
		$(this).addClass("selected");
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		
		var data = {
			"page"	:	page,
			"p"		:	{
				"s"		:	0,
				"pp"	:	50
			}
		};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/includes/"+page+".php",
			data		:	data,
			success 	: 	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
								$(".show_vertical_menu").trigger('click');
							},
			error		:	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
				
			}
		});
		
	});
	
	$(document).on("click", ".click", function(){
		var selector = $(this).attr("data-table");
		var data = {
			"page"	:	"menu",
			"p"		:	{
				"s"		:	0,
				"pp"	:	50
			}
		};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/includes/" + selector.toLowerCase() + ".php",
			data		:	data,
			success 	: 	function(response){
								$('.content').html(response);
								$(".modal").removeClass("show");
							},
			error		:	function(response){
								$(".debug").html("Error : " + response);
								$(".modal").removeClass("show");

			}
		});
	});
	
	//	IMOTICON 
	$(document).on("click","button.imoticon", function(){
		var cursorPos = $('#creative_body_chat').prop('selectionStart');
		var v = $('#creative_body_chat').val();
		var textBefore = v.substring(0,  cursorPos);
		var textAfter  = v.substring(cursorPos, v.length);
		var newText = $(this).val();
		$('#creative_body_chat').val(textBefore + newText + textAfter);
	});
	
});

$(window).on('load', function() {

	"use strict";
	
	var page = "index";
	var type = window.location.hash.substr(1);
	
	if(type !== ""){
		page = type;
	}
	
	
	$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
	
	var data = {
		"page"	:	page,
		"p"		:	{
			"s"		:	0,
			"pp"	:	50
		}
	};

	$.ajax({

		type		: 	"POST",
		url			: 	"pages/default/includes/"+page+".php",
		data		:	data,
		success 	: 	function(response){
							$('.content').html(response);
							$(".modal").removeClass("show");
						},
		error		:	function(response){
							$('.content').html(response);
							$(".modal").removeClass("show");

		}
	});	


	
	
});