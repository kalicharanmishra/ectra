// hide  category
function showcategory(e){
    var isChecked = $(e).is(':checked');
   if(isChecked){
$('.catlist').css('display','block');
   }else{
    $('.catlist').css('display','none');
   }
  }
//   hide price input
function showPrice(e){
    var isSelect = $("input[type='radio'][name='price_type']:checked").val();
   if(isSelect == "Paid"){
$('.price').css('display','block');
   }else{
    $('.price').css('display','none');
   }
  }
// image preview
  function img_pathUrl(input,id){
    $('#'+id)[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
}

//input type min today date
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
console.log(today)
$(".mindate").attr("min", today);