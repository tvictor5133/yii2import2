$(document).ready(function(){
   $(".img-del").on('click', function(e){
       e.preventDefault();
       if (confirm('Вы действительно хотите удалить изображение?')){
           var id = $(this).data('id');
           $(this).parent().detach();
           $.ajax({
               url: '/product/imgdel',
               data: {id: id},
               type: 'GET',
               success: function(res){
                   if (!res)
                       return false;
               },
               error: function(error){
                   alert(error);
                   return false;
               }
           });
       }
   });
});