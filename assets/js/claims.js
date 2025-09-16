document.addEventListener('click',function(e){
if(e.target && e.target.classList.contains('claim-view')){
 var id=e.target.getAttribute('data-id');
 var box=document.getElementById('claim-detail');box.textContent='Loading...';
 var xhr=new XMLHttpRequest();
 xhr.open('GET','/controller/claims_controller.php?action=view&id='+id,true);
 xhr.onload=function(){if(xhr.status===200){try{var d=JSON.parse(xhr.responseText);
 if(d.success){var c=d.claim;box.innerHTML='<h3>Claim #'+c.id+'</h3><p>'+c.claim_amount+'</p>';}
 else{box.textContent='Not found';}}catch(e){box.textContent='Invalid';}}};
 xhr.send();
}});
