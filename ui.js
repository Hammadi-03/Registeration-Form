document.addEventListener('DOMContentLoaded', function(){
  // Focus/blur handling for input groups
  document.body.addEventListener('focusin', function(e){
    const ig = e.target.closest && e.target.closest('.input-group');
    if(ig) ig.classList.add('focused');
  });
  document.body.addEventListener('focusout', function(e){
    const ig = e.target.closest && e.target.closest('.input-group');
    if(ig) ig.classList.remove('focused');
  });
  // Make radio/checkbox labels keyboard-friendly (space/enter)
  document.querySelectorAll('.input-wrapper label').forEach(function(lbl){
    lbl.addEventListener('keydown', function(e){
      if(e.key === ' ' || e.key === 'Enter'){
        e.preventDefault();
        const input = lbl.querySelector('input');
        if(input) input.click();
      }
    });
  });

  // Simple error handling: mark empty required fields on blur
  document.querySelectorAll('.input-field').forEach(function(inp){
    inp.addEventListener('blur', function(){
      const group = this.closest('.input-group');
      if(!group) return;
      if(this.required && this.value.trim() === '') group.classList.add('error');
      else group.classList.remove('error');
    });
    inp.addEventListener('input', function(){
      const group = this.closest('.input-group');
      if(!group) return;
      if(this.value.trim() !== '') group.classList.remove('error');
    });
  });
});