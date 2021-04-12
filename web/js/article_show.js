$(document).ready(function (){
$('.js-like-article').on('click',function (e){
    e.preventDefault();
    var $link=$(e.currentTarget);

    $link.toggleClass('fa fa-heart-o').toggleClass('fa-heart');

    $('.js-like-article-count').html('Test');

    $(document).ready(function (){
        $("td").css("color", "red");
    });

});
});