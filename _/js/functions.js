(function($){
	var event_type = 'click';
	
	$(document).ready(function (){
		

		$('body').on(event_type,'button#nav-btn', function(){	
			$('body').addClass('nav-open');
			$('#page').animate( {left: '-300px', opacity: 0.5}, 'fast');
			
			$('#main-nav').animate( {right: '0px', opacity: 1}, 'fast', function(){
				$(this).toggleClass('nav-closed nav-open').removeAttr('style');
			});
			
			return false;
		});	
		
		$('body').on(event_type,'button#close-nav-btn', function(){
			
			$('#page').animate( {left: '0px', opacity: 1}, 'fast', function(){
				$('body').toggleClass('nav-open nav-closed');
				$(this).removeAttr('style');	
			});
			
			$('#main-nav').animate( {right: '-300px', opacity: 0}, 'fast', function(){
				$(this).toggleClass('nav-open nav-closed').removeAttr('style');
			});
			
			return false;
		
		});	
		
	});
	
})(window.jQuery);