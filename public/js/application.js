function update_pagination(page_id){
  urll = 'pagination_ajax.php?page='+page_id;
  $.ajax({
         url: urll,
         success: function(data){
         $('table').html(data);
         }
      }); 
  return true;
}

// for the modal
$(document).ready(function(){
    if ($('#cookie-modal')[0]){
        $("#cookie-modal").modal({onClose:function (dialog) {
             loca = window.location.href;
             if(loca.indexOf("?") === -1){
                 loca = location+'?ticked_cookie=1';
             }else{
                 loca = location+'&ticked_cookie=1';
             }
             //redirect te brower back to the page
             window.location.replace(loca);
        }});
        $("#simplemodal-container").attr('style',"position: fixed; z-index: 1002; height: 100px; width: 200px; left: 100px; top: 100px;");    
    }        
            
    $('span.tableColumnsButton').click(function(){
        $('#basic-modal-content').modal();   
    });
    $('.uploadform a.jsonexample').click(function(){
        $('#basic-modal-content').modal();   
    });
            
    $('#q').click(function(){
	$(this).val('');
	$(this).attr('class', 'active');
      });
      
    $('footer a img').click(function(){
        form = $(this).parent().siblings('form');
        if(form.hasClass("displaynone")){
            form.removeClass("displaynone");
        }else{
            form.addClass("displaynone");
        }
	return false;
    });
});

