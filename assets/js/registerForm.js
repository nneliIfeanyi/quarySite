const steps = document.querySelectorAll('.form-step')
const nextBtn = document.querySelector('#nextBtn')
const prevBtn = document.querySelector('#prevBtn')

let currentStep = 0


// FORM STEPS
const showStep = (index) => {
  steps.forEach((step, i) => {
    step.classList.toggle('d-none', i !== index)
  });

  // Disable Prev button on first step
  prevBtn.disabled = index === 0

  // Change Next button to Submit on last step
  if (index === steps.length - 1) {
    nextBtn.textContent = 'Submit'
    nextBtn.type = 'submit'
  } else {
    nextBtn.textContent = 'Next'
    nextBtn.type = 'button'
  }
}

// Event Listener
nextBtn.addEventListener('click', () => {
  if (nextBtn.type === 'submit') return // Allow form submission 

  if (currentStep < steps.length) {
    currentStep++
    showStep(currentStep)
  }
})

prevBtn.addEventListener('click', () => {
  if (currentStep > 0) {
    currentStep--
    showStep(currentStep)
  }
})

// Initialize
showStep(currentStep)