//jquery for the travelling widget
// to be used on the travelling widget page
$(document).ready(function(){
    
    set_up_event_handlers();

});

function set_up_event_handlers(){
    
    $('span.tableColumnsButton').click(function(){
        $('#basic-modal-content').modal();   
    });
    
    $('#q').click(function(){
	$(this).val('');
	$(this).attr('class', 'active');
    });
    //put in onsubmit clauses to the forms
    //form 0 is the search form..
    $($('form')[0]).submit(
            function(event){
                action = $(this).attr('action');
                q = $(this).find('input[name="q"]').val();
                table = $(this).find('input[name="table"]').val();
                column = $(this).find('select').val();
                uri = action + '/just_the_table?callback=json_callback&q='+q+'&table='+table+'&column='+column;
                $.ajax({
                    type: 'GET',
                    url: uri,
                    async: false,
                    jsonpCallback: 'json_callback',
                    contentType: "application/json",
                    dataType: 'jsonp',
                    success:function(data){
                        $('section').replaceWith(data);
                        set_up_event_handlers();
                    }
              });
              return false;
            });
            
    //form 1 is the columns form..
    $($('form')[1]).submit(
            function(event){
                action = $(this).attr('action');
                uri = action +'/just_the_table?callback=json_callback&' + $($('form')[1]).serialize();
                $.ajax({
                    type: 'GET',
                    url: uri,
                    async: false,
                    jsonpCallback: 'json_callback',
                    contentType: "application/json",
                    dataType: 'jsonp',
                    success:function(data){
                        $('section').replaceWith(data);
                        set_up_event_handlers();
                    }
                });
                return false;
            });
            
   //deal with the href entries which include pagination and ordering..        
    $('a').each(function(index, value){
           $(this).click(function(){
              if ($(this).attr("target") !== undefined){
               return true;
              }
              href = $(this).attr("href");
              uri = href.replace('table','table/just_the_table' );
              //issue with the table
              uri = uri.replace('url=table%2Fas_javascript&', 'callback=json_callback&');
              
              $.ajax({
                    type: 'GET',
                    url: uri,
                    async: false,
                    jsonpCallback: 'json_callback',
                    contentType: "application/json",
                    dataType: 'jsonp',
                    success:function(data){
                        $('section').replaceWith(data);
                        set_up_event_handlers();
                    }
              });
              
              return false;  
           });
    }); 
    
}