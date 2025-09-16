document.addEventListener('click',function(e){
if(e.target && e.target.classList.contains('bill-view')){
 var id=e.target.getAttribute('data-id');
 var box=document.getElementById('bill-detail');box.textContent='Loading...';
 var xhr=new XMLHttpRequest();
 xhr.open('GET','/controller/billing_controller.php?action=view&id='+id,true);
 xhr.onload=function(){if(xhr.status===200){try{var d=JSON.parse(xhr.responseText);
 if(d.success){var b=d.bill;box.innerHTML='<h3>Bill #'+b.id+'</h3><p>'+b.amount+'</p>';}
 else{box.textContent='Not found';}}catch(e){box.textContent='Invalid';}}};
 xhr.send();
}});
