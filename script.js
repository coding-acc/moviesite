function sendfav(index, togglefav){
    
    $(document).ready(function (){
    var id = $('#i'+index).val();
    console.log(id);

    $.ajax({
        type: "POST",
        url: "fav.php",
        data: {
            movid: id
        },
        success: function(response){
            console.log("SENDING");
           // $("#display").html(response).show();
            //$("#display").hide();
        }
    });
});     

} 

$(document).ready(function() {
    
    $("#search").keyup(function() {
        
        var name = $('#search').val();
        const dropbox = $('.drop');
        console.log(dropbox);
        

let emptyarray = [];

        
        if (name == "") {
        
           // $("#display").html("");
           $('#3').css('pointer-events','auto');
           dropbox.html("");
        }
        //If name is not empty.
        else {
            
            //AJAX is called.
            $.ajax({
                
                type: "POST",
                
                url: "search.php",
                
                data: {
                    
                    search: name
                },
                
                success: function(html) {
                    
                    $('#3').css('pointer-events','none');
                   dropbox.html(html);
                   dropbox.css({'pointer-events':'auto','background':'none', 'opacity':'0.95', 'color':'black', 'border-radius':'8px', 'text-align':'left', 'max-width':'200px', 'z-index':'1'});
                   
                }
            });
        }
    });
    
    $('.faved').click(function(){
        const wrapper = $('.movie-wrapper');
        const otherw = document.querySelector('[class="movie-wrapper"]');
        //returnhome(wrapper.children);
        //console.log(otherw.children);
        //returnhome(otherw.children);
        wrapper.html("");
        getfavs=1;
        $.ajax({
                
            type: "POST",
            
            url: "favpage.php",
            
            data: {
                
                sendfavs: getfavs
            },
            
            success: function(update) {
                
                wrapper.html(update);
               
            }
        });
    });

   
});