const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navigation');

hamburger.addEventListener('click', () => {
  navMenu.classList.toggle('open');
});
  const loginBtn = document.querySelector('.btnLogin-popup');
    const wrapper = document.getElementById('loginWrapper');
    const closeBtn = document.getElementById('closeBtn');

    loginBtn.addEventListener('click', () => {
      wrapper.classList.add('active-popup');
    });

const cards = document.querySelectorAll('.carousel-card');
let current = 0;

function showCard(index) {
  cards.forEach((card, i) => {
    card.classList.toggle('active', i === index);
  });
}

function nextCard() {
  current = (current + 1) % cards.length;
  showCard(current);
}

if(cards.length > 0) {
  showCard(current);
  setInterval(nextCard, 4000); // change every 4 seconds
}

