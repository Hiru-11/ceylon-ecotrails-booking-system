
// Code to play the video on the Home Page on loop
const heroVideo = document.querySelector('.hero-video');
if (heroVideo) {
  heroVideo.addEventListener('timeupdate', () => {
    if (heroVideo.currentTime > 24) {
      heroVideo.currentTime = 0;
    }
  });
}


// To display the tour content in the tour card once the 'More Info' Button is clicked

window.addEventListener('load', () => {
  const toggleButtons = document.querySelectorAll('.toggle-btn');

  toggleButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const content = btn.closest('.tour-card').querySelector('.tour-content');

      // Initialize hidden if not already
      if (!content.style.display || content.style.display === '') {
        content.style.display = 'none';
      }

      // Toggle visibility
      if (content.style.display === 'none') {
        content.style.display = 'block';
        btn.textContent = 'Less Info';
      } else {
        content.style.display = 'none';
        btn.textContent = 'More Info';
      }
    });
  });
});

// This code creates a calendar for December 2025 and highlights days with events. Clicking on an event day shows its details below the calendar.
document.addEventListener('DOMContentLoaded', () => {
  const calendarContainer = document.getElementById('calendar');
  const eventDetails = document.getElementById('event-details');

  // Only run if this page has a calendar section
  if (calendarContainer && eventDetails) {

    const events = [
      {
        date: '2025-12-10',
        title: 'Eco Awareness Festival',
        location: 'Kandy City Park',
        description: 'Eco talks, recycling workshops, tree planting, and local music shows.'
      },
      {
        date: '2025-12-18',
        title: 'Rainforest Conservation Camp',
        location: 'Sinharaja Rainforest',
        description: 'Trail restoration, tree planting, wildlife observation, and eco-camping.'
      },
      {
        date: '2025-12-27',
        title: 'Mountain Clean-Up Challenge',
        location: 'Knuckles Mountain Range',
        description: 'Hiking, cleanup drive, team competitions, and eco-awareness sessions.'
      }
    ];

    const now = new Date(2025, 11); // December 2025
    const year = now.getFullYear();
    const month = now.getMonth();

    const renderCalendar = () => {
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      calendarContainer.innerHTML = `
        <div class="calendar-header">
          <button id="prev">‹</button>
          <span>${now.toLocaleString('default', { month: 'long' })} ${year}</span>
          <button id="next">›</button>
        </div>
        <div class="calendar-grid">
          <div><strong>Sun</strong></div>
          <div><strong>Mon</strong></div>
          <div><strong>Tue</strong></div>
          <div><strong>Wed</strong></div>
          <div><strong>Thu</strong></div>
          <div><strong>Fri</strong></div>
          <div><strong>Sat</strong></div>
        </div>
      `;

      const grid = document.createElement('div');
      grid.classList.add('calendar-grid');

      for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement('div');
        empty.classList.add('calendar-day', 'inactive');
        grid.appendChild(empty);
      }

      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const isoDate = date.toISOString().split('T')[0];
        const event = events.find(e => e.date === isoDate);

        const cell = document.createElement('div');
        cell.classList.add('calendar-day');
        cell.textContent = day;

        if (event) {
          cell.classList.add('event-day');
          cell.addEventListener('click', () => showEvent(event));
        }

        grid.appendChild(cell);
      }

      calendarContainer.appendChild(grid);
    };

    const showEvent = (event) => {
      eventDetails.style.display = 'block';
      eventDetails.innerHTML = `
        <h3>${event.title}</h3>
        <p><strong>Date:</strong> ${event.date}</p>
        <p><strong>Location:</strong> ${event.location}</p>
        <p>${event.description}</p>
      `;
      eventDetails.scrollIntoView({ behavior: 'smooth' });
    };

    renderCalendar();
  }
});
