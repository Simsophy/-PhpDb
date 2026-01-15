function preview(event){
var img=document.getElementById('img');
img.src=URL.createObjectURL(event.target.files[0]);
}
function get_user(id){
    document.getElementById('user_id').value=id;
}