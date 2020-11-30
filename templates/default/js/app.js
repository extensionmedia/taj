
$(document).ready(function() {
	
	"use strict";
	

	$(document).mouseup(function(e) {
		var container = $(".search_result_container");

		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			$(".search_result_container .search_result").addClass("hide");
		}
	});
		

	/****************************
			LOCATION
	*****************************/	
	
	/*************************************
											Edit
	*************************************/
	
	// On change price of produit
	$(document).on('change', '._produit .produit_prix_location', function(){
		
		var du = 0;
		var avoir = 0;
		
		$('.produit_prix_location').each(function(){

			if($(this).parent().parent().find(".on_off").length){
				if($(this).parent().parent().find(".on_off").hasClass("on")){
					du += parseInt( $(this).val() );
				}else{
					avoir += parseInt( $(this).val() );
				}
			}else{
				du += parseInt( $(this).val() );
			}
			
		});
		
		$(".total_location").html("Total : " + du + ",00 Dh");
		$(".total_avoir").html("Avoir : " + avoir + ",00 Dh");
		$(".total_location").attr("data-du", du);
		$(".total_location").attr("data-avoir", avoir);
		
	});	
	
	// On change On/Off of produit
	$(document).on('click', '.location_list table tbody tr._produit .on_off',function(){
		
		var du = 0;
		var avoir = 0;
		var this_price = parseInt($(this).parent().parent().find(".produit_prix_location").val());
		
		var is_on = $(this).hasClass("on")? true: false;
		
		
		
		
		$('.produit_prix_location').each(function(){

			if($(this).parent().parent().find(".on_off").length){
				if($(this).parent().parent().find(".on_off").hasClass("on")){
					du += parseInt( $(this).val() );
				}else{
					avoir += parseInt( $(this).val() );
				}
			}else{
				du += parseInt( $(this).val() );
			}
			
		});
		
		if(is_on){
			du -= this_price;
			avoir += this_price;
		}else{
			du += this_price;
			avoir -= this_price;
		}
		
		$(".total_location").html("Total : " + du + ",00 Dh");
		$(".total_avoir").html("Avoir : " + avoir + ",00 Dh");
		$(".total_location").attr("data-du", du);
		$(".total_location").attr("data-avoir", avoir);

	});
	
	// Show Location Edit Form
	$(document).on('click', '.location .edit', function(){
		var uid = $(this).attr("data-UID");
		
		var data = {
			'UID' 	 		: 	uid
		};
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/edit.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:60%; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});
		
	});
	
	// Show List of Produit to select
	$(document).on('click', '.location_list .add_produit', function(){

		var _this = $(this);
		
		var data = {
			'module' 	 	: 	'select_produit',
			'UID'			:	$(this).val()
		};
		
		/*
		$.post("pages/default/ajax/location/vues/select_produit.php",data, function(r){
			_this.parent().parent().html(r);
			//$(".debug").html(r);
			//alert(r);
		});
		*/

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/select_produit.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			_this.parent().parent().html(response.msg);
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});

		
	});
	
	// Select produit Edit Location
	$(document).on('click', '.select_this_produit_edit', function(){
		var UID = $(this).attr("data-UID");
		var produi_id = $(this).attr("data-produit-id");
		var produi_code = $(this).attr("data-produit-code");
		var produi_taille = $(this).attr("data-produit-taille");
		var produi_libelle = $(this).attr("data-produit-libelle");
		var produi_prix_location = $(this).attr("data-produit-prix_location");
		var produi_category = $(this).attr("data-produit-category");
		var produi_UID = $(this).attr("data-produit-UID");
		var barcode = $(this).attr("data-barcode");
		
		var new_tr = '	<tr class="_produit">';
			new_tr += '		<td class="hide produit_id">'+produi_id+'</td>';
			new_tr += '		<td style="width:102px; max-width:102px;">'+produi_code+'<div style="font-size:8px; color:red"><i class="fas fa-barcode"></i> '+barcode+'</div></td>';
			new_tr += '		<td>'+produi_libelle+' <span style="font-size:10px; font-weight:bold; color:black">Taille : '+produi_taille+'</span></td>';
			new_tr += '		<td style="width:102px; max-width:102px;"><input class="produit_prix_location" style="text-align:right" type="number" value="'+produi_prix_location+'"></td>';
			new_tr += '		<td style="width:70px; max-width:70px"><button class="btn btn-red delete_this_produit">Supp.</button></td>';
			new_tr += '	</tr>';
		
			new_tr += '	<tr>';
			new_tr += '		<td colspan="6" style="padding:10px 7px;"> ';
			new_tr += '			<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">';
			new_tr += '				<button class="btn btn-default add_produit" value="'+UID+'"><i class="fas fa-search-plus"></i> Ajouter Produits </button>';
			new_tr += '			</div>';
			new_tr += '		</td>';
			new_tr += '	</tr>';
		
		$('.location_list table tbody tr:last-child').remove();
		$('.location_list table tbody').append(new_tr);
			
		$('._produit .produit_prix_location').trigger('change');
	});
	
	// Remove added produit on edit
	$(document).on('click', '.delete_this_produit', function(){
		$(this).parent().parent().remove();
		$('._produit .produit_prix_location').trigger('change');
	});
	
	
	$(document).on('click', '.location_save_edit', function(){
		
		var produits = {};
		var i=0;
		
		var status;
		
		$("tr._produit").each(function(){

			if($(this).find("td .on_off.on").length){ status = 1; }
			
			if($(this).find("td .on_off.off").length){ status = 0; }
			
			if($(this).find("td .delete_this_produit").length){ status = 1; }
		
			
			produits[i] = {
				'id'		: 	$(this).find(".produit_id").html(),
				'prix'		: 	$(this).find(".produit_prix_location").val(),
				'status'	:	status
			};
			i++;

		});

		
		var success = true;
		
		
		var columns = {
			"id"				:	$("#id").val(),
			"UID"				:	$("#UID").val(),
			"date_debut"		:	$("#date__debut").val(),
			"date_fin"			:	$("#date__fin").val(),
			"location_status"	:	$(".location_status.checked").attr("data-id"),
			"client"			:	$("#client").val(),
			"telephone"			:	$("#telephone").val(),
			"remarques"			:	$("#remarques").val(),
			"remise"			:	0
		};
		
		var data = {
			't_n'		:	'Location',
			'columns'	:	columns,
			'produits'	:	produits
		};
		
		console.log(data);
		
		if(success){
			$.post("pages/default/ajax/location/save.php", data, function(r){
				if(r === "1"){
					$('.modal .modal-content').html("");
					$('.modal').removeClass("show");
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
						url			: 	"pages/default/includes/location.php",
						data		:	data,
						success 	: 	function(response){
							$('.content').html(response);
										},
						error		:	function(response){
											$(".debug").html("Error : " + response);

						}
					});
				}else{
					$(".debug").html(r);
				}
			});				
		}
		
		
	});
	
	/*************************************
											Paiement / Caisse
	*************************************/
	// Show Location Paiement Form
	$(document).on('click', '.location .paiement', function(){
		var uid = $(this).attr("data-id");
		
		var data = {
			'id_location' 	 		: 	uid
		};
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		
		/*	$.post("pages/default/ajax/location/vues/paiement.php", data, function(r){ $(".debug").html(r);	}) */
		
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/paiement.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:300px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});

	});
		
	// When avance changes show Rest in label
	$(document).on('keyup', '#avance', function(){
		var current_reste = parseInt($(this).attr("data-reste"));
		var value = $(this).val() === ""? 0: parseInt($(this).val());
		
		console.log(value-current_reste);
		
		if(value === "NaN"){
			$(".lbl_reste").html("Reste : " + current_reste + " Dh");
		}else if(value > current_reste){
			$(".lbl_reste").html("Error !");
		}else{
			$(".lbl_reste").html("Reste : " + (current_reste-value) + " Dh");
		}
		
	});
	
	// Save New Paiement of Location
	$(document).on('click', '.paiement_save', function(){
		
		if($(".lbl_reste").html() === "Error !"){
			alert("Vérifier les montants");
		}else{
			
			var price = parseInt($("#avance").val());
			var type = $(".type.checked").attr("data-id");
				
				
			if( price < 0 && type === "1" ){
				alert("Changer à Sortie");
			}else{
				var data = {
					't_n'	:	'Caisse_Mouvement',
					columns : {
								'type'			:	$(".type.checked").attr("data-id"),
								'avance'		:	$("#avance").val(),
								'id_location'	:	$(this).val(),
								'date_caisse'	:	$("#date_paiement").val()
							}
				};

				$.post("pages/default/ajax/caisse_mouvement/save.php", data, function(r){
					if(r === "1"){
						$(".actions .refresh").trigger('click');

					}else{
						$(".debug").html(r);
					}
				});				
			}
			
			

		}
		
	});
	
	// Show Ticket Form
	$(document).on('click', '.location .ticket', function(){
		var uid = $(this).attr("data-id");
		
		var data = {
			'id_location' 	 		: 	uid
		};
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		
		//$.post("pages/default/ajax/location/vues/ticket.php", data, function(r){ $(".debug").html(r);	}) 
		
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/ticket.php",
			data		:	data,
			dataType	: 	"text",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:300px; padding:0; border:0; border-radius:3px'>" + response + "</div>");

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});

	});
	
	// Check to Terminer Location
	$(document).on('click', '.location .terminer', function(){
		var uid = $(this).attr("data-id");
		
		var data = {
			'id_location' 	 		: 	uid
		};
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		
		//$.post("pages/default/ajax/location/vues/ticket.php", data, function(r){ $(".debug").html(r);	}) 
		
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/terminer.php",
			data		:	data,
			dataType	: 	"text",
		}).done(function(response){
			
			$(".refresh").trigger("click");
			$(".modal").html("").removeClass("show");

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});

	});
	
	$(document).on('change', '#location_avance', function(){
		var total_location = 0;
		var du = 0;
		var avoir = 0;
		
		$('.produit_prix_location').each(function(){
			total_location += parseInt( $(this).val() );
			if($(this).parent().parent().find("on_off").hasClass("on")){
				du += parseInt( $(this).val() );
			}else{
				avoir += parseInt( $(this).val() );
			}
			
			
		});
		
		$(".total_location").html("Total : " + du + ",00 Dh");
		$(".total_location").attr("data-du", du);
		$(".total_location").attr("data-avoir", avoir);
		var total_remise = $("#location_remise").val();
		var total_avance = $("#location_avance").val();
		$("#location_reste").val(du-total_remise-total_avance);
		
	});
		
	/*************************************
											Add
	*************************************/
	
	// Show Form to select Dates and Type
	$(document).on('click', '.add_check', function(){
		
		/* $.post("pages/default/ajax/annonce_category/util.php",data, function(r){ $(".debug").html(r); alert(r); }); */
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/location/vues/add/select_date.php",
			dataType	: 	"text",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:380px; padding:0; border:0; border-radius:3px'>" + response + "</div>");
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});
		
	});
	
	// Change date_debut and date_fin
	$(document).on('click', '.change__date', function(){
		var nbr_jours = parseInt( $("#nbr_jours").html() );
		var d1 = $("#date__debut").val();

		if($(this).val() === "+"){
			$("#date__fin").val(moment(d1).add( 1+nbr_jours , "days" ).format("YYYY-MM-DD"));
			$("#nbr_jours").html(1+nbr_jours);
			$("#nbr_jours").css("background-color", "#66BB6A");
		}else{
			if(nbr_jours>0){
				$("#date__fin").val(moment(d1).add( nbr_jours-1 , "days" ).format("YYYY-MM-DD"));
				$("#nbr_jours").html(nbr_jours-1 );
				$("#nbr_jours").css("background-color", "#66BB6A");	
			}else{
				$("#nbr_jours").css("background-color", "#E57373");	
			}

		}
		//$("#date__debut").trigger('change');

	});

	// Show first step to edit dates
	$(document).on('click', '.first_step_edit', function(){
		
		/* $.post("pages/default/ajax/annonce_category/util.php",data, function(r){ $(".debug").html(r); alert(r); }); */
		
		var data = {
			'date_debut'	:	$("#date_debut").val(),
			'date_fin'		:	$("#date_fin").val(),
			'nbr_jours'		:	$("#nbr_jours").html(),
			'id_status'		:	$("#id_location_status").html()
		};
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		$.ajax({
			type		: 	"POST",
			data		:	data,
			url			: 	"pages/default/ajax/location/vues/add/select_date_edit.php",
			dataType	: 	"text",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:380px; padding:0; border:0; border-radius:3px'>" + response + "</div>");
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});
		
	});
	
	// Change date_debut and date_fin When Edit
	$(document).on('click', '.change___date', function(){
		var nbr_jours = parseInt( $("#nbr___jours").html() );
		var d1 = $("#date___debut").val();

		if($(this).val() === "+"){
			$("#date___fin").val(moment(d1).add( 1+nbr_jours , "days" ).format("YYYY-MM-DD"));
			$("#nbr___jours").html(1+nbr_jours);
			$("#nbr___jours").css("background-color", "#66BB6A");
		}else{
			if(nbr_jours>0){
				$("#date___fin").val(moment(d1).add( nbr_jours-1 , "days" ).format("YYYY-MM-DD"));
				$("#nbr___jours").html(nbr_jours-1 );
				$("#nbr___jours").css("background-color", "#66BB6A");	
			}else{
				$("#nbr___jours").css("background-color", "#E57373");	
			}

		}

	});

	
	// First step : Select type and dates : Save
	$(document).on('click', '.first_step', function(){
		if($("#nbr_jours").html() === "0"){
			alert("Verifier les dates");
		}else{
			var location_status = $(".location_status.checked").val();
			var id_location_status = $(".location_status.checked").attr("data-id");
			var color = $(".location_status.checked").attr("data-color");
			var date_debut =  $("#date__debut").val();
			var date_fin =  $("#date__fin").val();
			var nbr_jours =  $("#nbr_jours").html();
			
			var data = {
				"module"	:	"first_step",
				"data"	: {
					"location_status"	:	location_status,
					"date_debut"		:	date_debut,
					"date_fin"			:	date_fin,
					"nbr_jours"			:	nbr_jours,
					"id_status"			:	id_location_status,
					"color"				:	color
				}
			};
			
			$(this).find(".is_doing").removeClass("hide");
			$(this).find(".do").addClass("hide");
			$(this).prop("disabled",true);

			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/location/util.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				
				if (response.code === 1){
					$(".modal").html("<div class='modal-content' style='width:380px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
					$(this).find(".is_doing").addClass("hide");
					$(this).find(".do").removeClass("hide");
					$(this).prop("disabled",false);
					
					$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
					var data = {
						"page"	:	"Location"
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/ajax/location/form.php",
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
					$(".modal").html("<div class='modal-content' style='width:380px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
					$(this).find(".is_doing").addClass("hide");
					$(this).find(".do").removeClass("hide");
					$(this).prop("disabled",false);
				}

			}).fail(function(response, textStatus){
				$(".debug").html(textStatus);
					$(this).find(".is_doing").addClass("hide");
					$(this).find(".do").removeClass("hide");
					$(this).prop("disabled",false);
			});
		}
	});	
	
	// Edit Dates and Type of Location : Show From
	$(document).on('click', '.first_step_edit_save', function(){
		if($("#nbr_jours").html() === "0"){
			alert("Verifier les dates");
		}else{
			var location_status = $(".location_status.checked").val();
			var id_location_status = $(".location_status.checked").attr("data-id");
			var color = $(".location_status.checked").attr("data-color");
			var date_debut =  $("#date___debut").val();
			var date_fin =  $("#date___fin").val();
			var nbr_jours =  $("#nbr___jours").html();
			
			$("table.status tr").css("background-color", color);
			$("table.status tr td").html(location_status);
			$("#date_debut").val(date_debut);
			$("#date_fin").val(date_fin);
			$("#nbr_jours").html(nbr_jours);
			$("#id_location_status").val(id_location_status);
			
			$(".modal").html("").removeClass("show");
		}
	});
		
	// Select Produit from list to Add
	$(document).on('click', '.location_add_produit', function(){
		var data = {
			'module' 	 	: 	'select_produit',
			'params'		:	{ 'UID' : $(this).val()}
		};
		
		/*
		$.post("pages/default/ajax/produit/util.php",data, function(r){
			$(".debug").html(r);
			//alert(r);
		});
		*/
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/produit/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			$(".modal").html("<div class='modal-content' style='width:60%; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});
		
	});
	
	// Refresh the list of produits to Add
	$(document).on('click', '.location_refresh', function(){
		
		var data = { "UID" :$(this).val() };	
		
		if($(this).hasClass("edit")){data.module = "refresh_edit";}

		$(".location_list").html("<div style='width:340px; margin:25px auto; text-align:center'><div style='font-size:35px;color:#F48FB1'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div><div style='color:#D81B60; font-weight:bold'>Recherche en cours ... </div></div>");
		
		$.post("pages/default/ajax/location/vues/add/get_produits_list.php", data, function(r){
			$(".location_list").html(r);
		});
		

	});
		
	// Save the form of Add Location
	$(document).on('click', '.save_form_location', function(){
		
		var success = true;
		
		
		var columns = {
			"UID"				:	$(".UID").html(),
			"date_debut"		:	$("#date_debut").val(),
			"date_fin"			:	$("#date_fin").val(),
			"client"			:	$("#client").val(),
			"telephone"			:	$("#telephone").val(),
			"remarques"			:	$("#remarques").val(),
			"location_status"	:	$("#id_location_status").html(),
			"avance"			:	$("#total_avance").val()===""? 0: $("#total_avance").val() ,
			
		};
		
		if($(this).hasClass("edit")){
			columns.id = $(this).attr("data-id");
		}
		var produits = {};
		
		$(".location_list table tbody tr._produit_add").each(function(){
			console.log($(this).find(".produit_id").html());
			produits[$(this).find(".produit_id").html()] = $(this).find(".produit_prix_location").val();
		});
		
		if($("#total_location").val() === "0"){
			alert("Verifier les produits");
			success = false;
		}

		if($("#client").val() === ""){
			alert("Client non valide");
			$("#client").addClass("error");
			success = false;
		}
		if($("#client").val() === ""){
			alert("Téléphone Non valide");
			$("#telephone").addClass("error");
			success = false;
		}
		var data = {
			't_n'		:	'Location',
			'columns'	:	columns,
			'produits'	:	produits
		};
		
		console.log(produits);
		
		if(success){
			$.post("pages/default/ajax/location/save.php", data, function(r){
				if(r === "1"){
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
						url			: 	"pages/default/includes/location.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
										},
						error		:	function(response){
											$(".debug").html("Error : " + response);

						}
					});
				}else{
					$(".debug").html(r);
				}
			});				
		}

		
	}); 
	
	// Remove the Selected produit
	$(document).on('click', '.remove_this_produit', function(){
		var UID = $(this).attr("data-UID");
		var id = $(this).attr("data-produit-id");
		
		
		var data = {
			"module" : "remove",
			"params" : {
							"UID" 		: 	UID,
							"id"		:	id
						}
			};

		$.post("pages/default/ajax/produit/util.php", data, function(r){
			$(".debug").html(r);
			$('.location_refresh').trigger('click');
			

		});			

	});
	
	$(document).on('change', '#total_avance', function(){
		
		var total_location = 0;
		var total_avance = parseInt( $(this).val() );
		
		$('.produit_prix_location').each(function(){
			total_location += parseInt( $(this).val() );
		});
		
		$("#total_location").val(total_location + " Dh");
		$("#total_reste").val((total_location - total_avance) + " Dh");

		if( (total_location - total_avance) < 0 ){
			$("#total_reste").addClass("error");
		}else{
			$("#total_reste").removeClass("error");
		}
		
		
	});
	
	$(document).on('change', '.produit_prix_location', function(){
		$('#total_avance').trigger('change');
	});

	$(document).on('change','#color',function(){
		var element = $(this).find('option:selected');  
		var color = element.attr('data-hex');
		$("#color_display").css('background-color', color);
	});
	
	$(document).on('click', '.location_edit_header', function(){
		var UID = $(this).attr("data-UID");
		
	})
	
	$(document).on('click', '.show_produits', function(e){
		e.preventDefault();
		
		$(".content").append("<div class='vertical_menu_produits' style='position:absolute; z-index:99999; width:50%; height:350px; background-color:blue; top:50px; right:0; margin-right:50%'><h1>Liste of produits</h1></div>");
		$(".vertical_menu_produits").animate({
				marginLeft: '+=350px'
			},500);
	});
			
	$(document).on('change', '#date__debut', function(){
		
		var d1 = $("#date__debut").val();
		var d2 = $("#date__fin").val();
		
		var start = moment(d1, "YYYY-MM-DD");
		var end = moment(d2, "YYYY-MM-DD");
		var nbr_jours = $("#nbr_jours").html();
		console.log(nbr_jours);
		$("#date__fin").val(moment(d1).add( nbr_jours, "days" ).format("YYYY-MM-DD"));
		$("#nbr_jours").css("background-color", "#66BB6A");		
	});

	$(document).on('click', 'ul.produit_category_list li', function(){
		
		$("ul.produit_category_list li").removeClass('selected');
		$(this).addClass("selected");
		
		var UID = $(this).attr("data-UID");
		
		var data = {
			'module' 	 	: 	'select_produit_request',
			'params'			:	{
						'request'				:	$("#request_select").val(),
						'id_produit_category'	:	$(this).attr("data-id"),
						'UID'					:	UID	
						
							}
		};
		if($(this).parent().hasClass("edit")) { data.params.edit = 1; }
		/*
		$.post("pages/default/ajax/produit/util.php",data, function(r){
			$(".debug").html(r);
			//alert(r);
		});
		*/

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/produit/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			$(".produit_list table tbody").html(response.msg );

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});
		
	});
	
	$(document).on('keyup', '#request_select', function(){
		
		var UID = $(this).attr("data-UID");
		
		var data = {
			'module' 	 	: 	'select_produit_request',
			'params'			:	{
						'request'				:	$("#request_select").val(),
						'id_produit_category'	:	$("#produit_category_select").val(),
						'UID'					:	UID
							}
		};
		if($(this).hasClass("edit")) { data.params.edit = 1; }
		/*
		$.post("pages/default/ajax/produit/util.php",data, function(r){
			$(".debug").html(r);
			//alert(r);
		});
		*/

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/produit/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			console.log(response.msg);
			$(".produit_list table tbody").html(response.msg );

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});

	});

	$(document).on('click', '.style .btn', function(){
		$('.location_refresh').trigger('click');
	});
	
	$(document).on('click', '.select_this_produit', function(){
		var UID = $(this).attr("data-UID");
		var produi_id = $(this).attr("data-produit-id");
		var produi_code = $(this).attr("data-produit-code");
		var produi_taille = $(this).attr("data-produit-taille");
		var produi_libelle = $(this).attr("data-produit-libelle");
		var produi_prix_location = $(this).attr("data-produit-prix_location");
		var produi_category = $(this).attr("data-produit-category");
		var produi_UID = $(this).attr("data-produit-UID");
		var barcode = $(this).attr("data-barcode");
		
		var data = {
			"module" : "add",
			"params" : {
							"UID" 				: 	UID,
							"id"				:	produi_id,
							"code"				:	produi_code,
							"taille"			:	produi_taille,
							"libelle"			:	produi_libelle,
							"prix"				:	produi_prix_location,
							"produit_category"	:	produi_category,
							"produit_UID"		:	produi_UID,
							"barcode"			:	barcode
						}
			};
		console.log(data.params);
		
		var _this = $(this);
		
		$(".location_list").html("<div style='width:340px; margin:25px auto; text-align:center'><div style='font-size:35px;color:#F48FB1'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div><div style='color:#D81B60; font-weight:bold'>Recherche en cours ... </div></div>");
		$.post("pages/default/ajax/produit/util.php", data, function(){
			//$(".debug").html(r);
			$(".search_result_container .search_result").addClass("hide");
			$('#search_request').val("");
			$('.location_refresh').trigger('click');
			_this.parent().html('<button style="padding:3px 10px" class="btn btn-default"><i class="fas fa-lock"></i> ...</button>');
			_this.remove();

		});			

	});

	$(document).on('click', '.location_menu_close', function(){
		$("body").toggleClass("overflow");
		$(this).remove();
		
	});
	
	$(document).on('click','.show_edit_ligne', function(){
		
		$("body").toggleClass("overflow");
		var status = $(this).attr("data-status");
		
		var ID = $(this).val();
		
		var menu = '';		
		if(status === "LOCATION"){
			menu += '<div class="location_menu_close" style="position:fixed; z-index: 9999999; width: 100%; height:100%; top: 0px; background-color:rgba(0,0,0,0.2)">';
			menu += '	<div class="location_menu" class="animated bounceIn">';
			menu += '		<ul>';
			menu += '			<li class="edit_ligne" data-page="Location"><span class="id-ligne hide">'+ID+'</span><span class="icon"><i class="far fa-eye"></i></span><span class="txt">Voir</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-calendar-week"></i></span><span class="txt">Terminer</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-ban"></i></span><span class="txt">Annuler</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-receipt"></i></span><span class="txt">Ticket</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-cash-register"></i></span><span class="txt">Paiement</span></li>';
			menu += '			<li style="background-color:red; color:white"><span class="icon"><i class="fas fa-times"></i></span><span class="txt">Quitter</span></li>';

			menu += '		</ul>';
			menu += '	</div>';
			menu += '</div>';			
		}else if(status === "RESERVATION"){
		
			menu += '<div class="location_menu_close" style="position:fixed; z-index: 9999999; width: 100%; height:100%; top: 0px; background-color:rgba(0,0,0,0.2)">';
			menu += '	<div class="location_menu" class="animated bounceIn">';
			menu += '		<ul>';
			menu += '			<li class="edit_ligne" data-page="Location"><span class="id-ligne hide">'+ID+'</span><span class="icon"><i class="fas fa-pen-square"></i></span><span class="txt">Modifier</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-calendar-week"></i></span><span class="txt">Location</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-ban"></i></span><span class="txt">Annuler</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-receipt"></i></span><span class="txt">Ticket</span></li>';
			menu += '			<li><span class="icon"><i class="fas fa-cash-register"></i></span><span class="txt">Paiement</span></li>';
			menu += '			<li style="background-color:red; color:white"><span class="icon"><i class="fas fa-times"></i></span><span class="txt">Quitter</span></li>';

			menu += '		</ul>';
			menu += '	</div>';
			menu += '</div>';	
		}
		$(".location").append(menu);
	});

	/*****************************************************************************************************
		PRODUIT SECTION
	******************************************************************************************************/
	
	$(document).on('change','#upload_file_category',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_category",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=category/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on('change','#upload_file_produit',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_produit",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=produits/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on('click',".rotate", function(){
		var data = {
					link	:	$(this).val()
				};

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/produit/rotate_image.php",
			data		:	data,
			success 	: 	function(response){
								$(".debug").html(response);
								$(".show_files").trigger('click');
							},
			error		:	function(response){
								console.log(response);

			}
		});	

	});
	
	/*****************************************************************************************************
		MAGASIN SECTION
	******************************************************************************************************/
	
	$(document).on('change','#upload_file_magasin',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_magasin",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=magasin/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	/*****************************************************************************************************
		PERSON SECTION
	******************************************************************************************************/
	
	$(document).on('click', '.person_password_reset', function(){
		
		if($("#password").val() === "" || $("#login").val() === ""){
			alert("Valeurs Incorrect!");
		}else{
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			var id_person = $(this).val();
			var data = {
				'module' 	 : 'person',
				'options'	 : {'id_person': id_person, 'person_password':$("#password").val(), 'person_login':$("#login").val()}
			};
			/*
			$.post("pages/default/ajax/person/util.php",{'module':'person','options':{'id_person': id_person, 'person_password':$("#password").val()}}, function(r){
				$(".debug").html(r);
				alert(r);
			});
			*/


			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/person/util.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				if (response.code === 1){
					alert(response.msg);
					$(".debug").html("");
					$(".modal").html("").removeClass('show');

				}else{
					$(".debug").html('	<div class="info info-error info-dismissible"> <div class="info-message"> '+response+' </div> <a href="#" class="close" data-dismiss="info" aria-label="close">×</a></div>');
				}

			}).fail(function(response, textStatus){
				$(".debug").html(textStatus);
				$(".modal").html("").removeClass('show');
			});

		}
		
		
		
	});
	
	$(document).on('change','#upload_file_person',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_person",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=person/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	/***********************************************************************
		MENU SECTION
	************************************************************************/
	
	$(document).on('click', '.__menu .btn.order, .__sub .btn.order', function(){
		var data = {
			action 	: 	'',
			i		:	$(this).attr("data-id"),
			next	:	$(this).attr("data-id-n"),
			preview	:	$(this).attr("data-id-p"),
			order	:	$(this).attr("data-order")
		};
		
		if($(this).hasClass("up")){
			data.action = "UP";
		}else{
			data.action = "DOWN";
		}
		

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/menu/util.php",
			data		:	data,
			success 	: 	function(response){
								//$('.debug_client').html(response);
								location.reload();
							},
			error		:	function(response){
								$('.debug_client').html(response);

			}
		});
		
	});
		
	$(document).on('change','#icon',function(){
		$(".icon_display").html($(this).val());
	});

	/*****************************************************************************************************
		PARAMS SECTION
	******************************************************************************************************/

	$(document).on('click','.actions.params .save',function(){
		
		var lang = "";
		
		$(".lang").each(function(){
			if( $(this).hasClass("checked") ){
				lang = $(this).val();
			}
		});

		var columns = {
			'website_name*'				:	$("#website_name").val(),
			'website_language*'			:	lang,
			'website_support'			:	$("#website_support").val(),
			'website_phone'				:	$("#website_phone").val(),
			'website_description'		:	$("#website_description").val(),
			'website_keywords'			:	$("#website_keywords").val(),
			'website_google_analytics'	:	$("#website_google_analytics").val(),
			'website_facebook_pixel'	:	$("#website_facebook_pixel").val(),
			'smtp_username'				:	$("#smtp_username ").val(),
			'smtp_password'				:	$("#smtp_password ").val(),
			'smtp_host'					:	$("#smtp_host").val(),
			'imap'						:	$("#imap").val(),
			'port'						:	$("#port").val(),
			'api_whatsapp'				:	$("#api_whatsapp").val(),
			'id'		:	1
		};

		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === "" || columns[key] === "-1" ){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}

		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Params',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/params/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "La catégorie a été ajouté!", "success");
					var data = {
						"page"	:	"apropos",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/params.php",
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
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}

	});
	
	$(document).on('click','.api_send', function(){
		var data = {
			'token' 	:	$("#api_whatsapp").val(),
			'phone' 	: 	$("#api_number").val(),
			'msg' 		: 	$("#api_msg").val(),
			
		};
		
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/params/get.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".api_result").html("<div class='info info-success'><div class='info-message'> "+response.msg+'</div></div>');
				
			}else{
				$(".api_result").html("<div class='info info-error'><div class='info-message'> "+response.msg+'</div></div>');
			}
								
		}).fail(function(response, textStatus){
			$(".api_result").html(textStatus);
		});
		
	});
	
	
	/************************************************************************
		LIBRARY
	**************************************************************************/

	$(".show_library").on("click", function(){
		var data;
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		$.post("pages/default/includes/library.php",{'data':data},function(response){
			$(".modal").html("<div class='modal-content' style='width:450px; padding:0; border:0; border-radius:3px'>"+response+"</div>");
		});
		
	});
	
	$(document).on("click", ".delete_file", function(){

		var data = {
					link	:	$(this).val()
				};
		if( $("#id").length > 0) { data.id = $("#id").val(); }
		
		swal({
			  title: "Vous êtes sûr?",
			  text: "Êtes vous sûr de vouloir supprimer ce Fichier? ",
				type:"warning",
				showCancelButton:!0,
				confirmButtonColor:"#3085d6",
				cancelButtonColor:"#d33",
				confirmButtonText:"Oui, Supprimer!"
			}).then(function(t){
			  if (t.value) {

					$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
				  
					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/ajax/delete_file.php",
						data		:	data,
						success 	: 	function(){
											//alert(response);
											$(".modal").removeClass("show");
											$(".show_files").trigger('click');
										},
						error		:	function(){
											$(".modal").removeClass("show");
											$(".show_files").trigger('click');

						}
					});	


			  } else {

			  }
		});	
		
		

	});
	
	$(document).on("click", ".show_files", function(e){
		var data;
		
		if($(this).hasClass("produit")){
			console.log("Produit show files Clicked ! " + $(this).attr("data"));
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/produit/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
			
		}else if($(this).hasClass("person")){
			data = {
				id_produit	:	$(this).val()
			};
			$(".person_image").prepend("<div class='_loader' style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/person/get_picture.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.person_image .image').html(response);
								},
				error		:	function(response){
									$("._loader").remove();
									console.log(response);
									//$(".modal").removeClass("show");

				}
			});
		}else if($(this).hasClass("magasin")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/magasin/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
		}else if($(this).hasClass("category")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/produit_category/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
		}


	});
	
	$(document).on("click", ".upload_btn", function(){
		
		//$("#upload_file").trigger("click");

	});
	
	$(document).on('change','#creative_file_to_upload',function(){
		var id_client = $(this).attr("data");
		
		var params = {
			IdIputFile			:	"creative_file_to_upload",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=creative/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on('click', '.showImage', function(){
		var src = $(this).attr("src");
		$(".modal").removeClass("hide").addClass("show").html("<div class='modal-content'><img src='"+src+"' style='width:100%; height:auto'></div>");
	});
	

});
 
$(window).on("load", function() {
	
	if($("#myChart").length > 0){
		console.log("show_graph");
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/graph/graph_01.php",
			dataType	: 	"json",
		}).done(function(response){
				console.log(response);
				var _months = ["Jan","Fév","Mars","Avr","Mai","Juin","Juil","Août","Sept","Oct","Nov","Déc"];
				var months = [];
				var totals = [];
				for(var i in response){
					months.push(response[i].month);
					totals.push(response[i].total);
				}			
				
				draw("myChart","bar",months,totals);
			
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
			$(".modal").html("").removeClass('show');
		});		
	}
	

	
});

function draw(container, type, columns, data){
	var ctx = document.getElementById(container).getContext('2d');
	var myChart = new Chart(ctx, {
		type: type,
		data: {
			labels: columns,
			datasets: [{
				label: ' Recettes ',
				data: data,
				backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.3)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
				'rgba(255, 99, 132, 0.8)',
				'rgba(255, 206, 86, 0.7)',
				],
				borderWidth: 1
			}]
		},

		options: {
			elements: {
				line:{
					tension:0,
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:false
					}
				}]
			}
		}

	});
}
