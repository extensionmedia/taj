// JavaScript Document
//var moment = moment();
var emoment = moment();
/*

console.log(moment.add(-5, 'days')); // 'March'
*/
$(document).ready(function() {
	
	"use strict";
	
	var d = new Date();
  	var weekday = new Array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
	var months = new Array("Janvier","Février","Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Nevombre", "Décembre");
	
	//var date = moment();
	
	$(document).on('click', '.calendar-header .btn-group.style a', function(){
		
		$('.calendar-header .btn-group.style a').removeClass("selected");
		var current_counter = $(".calendar-header .btn-group.calendar a.direction").attr('data-counter');
		
		if($(this).attr('data-style') === 'week'){	//	week
			var d1 = weekday[0] + ", " + months[d.getMonth()] + ' ' + (d.getDate()-d.getDay()) + ', ' + d.getFullYear();
			var d2 = weekday[d.getDay()] + ", " + months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
			
			$('.calendar_current_interval').html(d1 + " - " + d2);
			
		}else if($(this).attr('data-style') === 'month' || $(this).attr('data-style') === 'vehicule'){	// month
			
			//d.setMonth(d.getMonth() + current_counter);
			var m = parseInt(d.getMonth());
			m = m + parseInt(current_counter);
			//var m = (parseInt(d.getMonth()) + current_counter);
			$('.calendar_current_interval').html(months[m] + ' / ' + d.getFullYear());
			
		}else{	// day
			
			$('.calendar_current_interval').html(weekday[d.getDay()] + ", " + months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear());
		}
		
		//var n = weekday[d.getDay()];
		$(this).addClass("selected");
		
		

		$('.calendar-header .btn-group.calendar a.direction').attr("data-counter", current_counter);
		$('.calendar-header .btn-group.calendar a.cl_refresh').trigger("click");
		
	});
	
	$(document).on('click', '.calendar-header .btn-group.calendar a.cl_refresh', function(){
		
		var counter = $('.calendar-header .btn-group.calendar a.direction').attr("data-counter");
			
		var style = "";
		
		$('.calendar-header .btn-group.style a').each(function(){
			if($(this).hasClass("selected")){
				style = $(this).attr("data-style");
			}
		});

		var data = {
				'style' 		: 	style,
				'counter'		:	counter,
			};	
		console.log(data);
		
		//$.post("pages/default/ajax/calendar/util.php", data, function(r){$(".debug").html(r);});
		
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/calendar/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").removeClass("show");
				$(".calendar-body").html(response.msg);
				
			}else{
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
			}	
			
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
			alert(textStatus);
		});
		

	});

	$(document).on('click', '.calendar-header .btn-group.calendar a.direction', function(){
		
		var counter = $(this).attr("data-counter");
		var action = $(this).attr("data-action");
		var style = "";
		
		$('.calendar-header .btn-group.style a').each(function(){
			if($(this).hasClass("selected")){
				style = $(this).attr("data-style");
			}
		});
		
		
		
		if(action === "next"){
			emoment.add(1, 'months');				
			$('.calendar_current_interval').html(months[emoment.format('M')-1] + ' / ' + emoment.format('YYYY'));
			$('.calendar-header .btn-group.calendar a.direction').attr("data-counter", (parseInt(counter) + 1));
		}else{
			emoment.add(-1, 'months');
			$('.calendar_current_interval').html(months[emoment.format('M')-1] + ' / ' + emoment.format('YYYY'));	
			$('.calendar-header .btn-group.calendar a.direction').attr("data-counter", (parseInt(counter) - 1));
		}
		//console.log(moment.format('MMMM') + " / " + emoment.format('MMMM'));
		$('.calendar-header .btn-group.calendar a.cl_refresh').trigger("click");
	});
	
	$(document).on('click', '.show_calendar', function(){
		parent.location.hash = "index";
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		
		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/includes/index.php",
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
	
});
