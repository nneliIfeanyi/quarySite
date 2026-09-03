const steps = document.querySelectorAll('.form-step')
const nextBtn = document.querySelector('#nextBtn')
const prevBtn = document.querySelector('#prevBtn')
const registrationForm = document.querySelector('#register')

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

const validateStep = (index) => {
  const fields = steps[index].querySelectorAll('input, select, textarea')
  let isValid = true

  registrationForm.classList.add('was-validated')

  fields.forEach((field) => {
    if (!field.checkValidity()) {
      isValid = false
    }
  })

  const firstInvalidField = steps[index].querySelector(':invalid')
  if (firstInvalidField) {
    firstInvalidField.reportValidity()
  }

  return isValid
}

const showFirstInvalidStep = () => {
  const firstInvalidField = registrationForm.querySelector(':invalid')
  if (!firstInvalidField) return true

  const invalidStep = [...steps].findIndex((step) => step.contains(firstInvalidField))
  if (invalidStep >= 0) {
    currentStep = invalidStep
    showStep(currentStep)
    validateStep(currentStep)
  }

  return false
}

// Event Listener
nextBtn.addEventListener('click', (event) => {
  if (nextBtn.type === 'submit') {
    if (!showFirstInvalidStep()) {
      event.preventDefault()
    }
    return
  }

  if (!validateStep(currentStep)) return

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

registrationForm.addEventListener('submit', (event) => {
  if (!showFirstInvalidStep()) {
    event.preventDefault()
  }
})

// Initialize
showStep(currentStep)