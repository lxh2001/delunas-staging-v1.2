// Progress Bar Function
const progress = document.getElementById("progress");
  const prev = document.getElementById("prev");
  const next = document.getElementById("next");
  const circles = document.querySelectorAll(".circle");
  let currentActive = 1;

  // Function to toggle steps and update progress
  function update() {
    circles.forEach((circle, idx) => {
      if (idx < currentActive) {
        circle.classList.add("active");
      } else {
        circle.classList.remove("active");
      }
    });

    const actives = document.querySelectorAll(".active");
    progress.style.width = ((actives.length - 1) / (circles.length - 1)) * 100 + "%";

    const steps = document.querySelectorAll(".step");
    steps.forEach((step, index) => {
      if (index === currentActive - 1) {
        step.style.display = "flex";
      } else {
        step.style.display = "none";
      }
    });

    if (currentActive === 1) {
      prev.disabled = true;
    } else if (currentActive === circles.length) {
      next.disabled = true;
    } else {
      prev.disabled = false;
      next.disabled = false;
    }
  }

  // Event listener for "next" button
  next.addEventListener("click", () => {
    currentActive++;
    if (currentActive > circles.length) {
      currentActive = circles.length;
    }
    update();
  });

  // Event listener for "prev" button
  prev.addEventListener("click", () => {
    currentActive--;
    if (currentActive < 1) {
      currentActive = 1;
    }
    update();
  });

  // Call the update function initially to set up the initial state
  update();

// Function on disabling buttons when schedule is already clicked
function selectThisTime(selectedButton) {
  const buttons = document.querySelectorAll(".time-btn");
  buttons.forEach((button) => {
    if (button !== selectedButton) {
      button.classList.add('time-btn-active');
    } else {
      button.classList.remove('time-btn-active');
    }
  });
}