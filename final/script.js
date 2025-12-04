
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.escala').forEach(group => {
    group.addEventListener('keydown', function(e) {
      const target = e.target;
      if (!target.classList || !target.classList.contains('nota')) return;
      let current = Array.prototype.indexOf.call(group.querySelectorAll('.nota'), target);
      if (e.key === 'ArrowRight' && current < group.querySelectorAll('.nota').length - 1) {
        e.preventDefault();
        const next = group.querySelectorAll('.nota')[current + 1];
        next.focus();
        next.previousElementSibling.checked = true; 
      } else if (e.key === 'ArrowLeft' && current > 0) {
        e.preventDefault();
        const prev = group.querySelectorAll('.nota')[current - 1];
        prev.focus();
        prev.previousElementSibling.checked = true;
      } else if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        target.click();
      }
    });

    group.querySelectorAll('.nota').forEach(label => {
      label.setAttribute('tabindex', '0');
    });
  });
});