document.addEventListener('click',function(e){
if(e.target && e.target.classList.contains('view-btn')){
 var id=e.target.getAttribute('data-id');
 var box=document.getElementById('doctor-detail');box.textContent='Loading...';
 var xhr=new XMLHttpRequest();
 xhr.open('GET','/controller/doctor_controller.php?action=view&id='+id,true);
 xhr.onload=function(){if(xhr.status===200){try{var d=JSON.parse(xhr.responseText);
 if(d.success){var doc=d.doctor;box.innerHTML='<h3>'+doc.full_name+'</h3><p>'+doc.specialty+'</p>';}
 else{box.textContent='Not found';}}catch(e){box.textContent='Invalid';}}};
 xhr.send();
}});
