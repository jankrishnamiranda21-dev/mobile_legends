// Example: Add a subtle fade in effect for hero cards
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.hero-card').forEach(card => {
    card.style.opacity = 0;
    setTimeout(() => {
      card.style.transition = 'opacity 1s';
      card.style.opacity = 1;
    }, 200);
  });
});