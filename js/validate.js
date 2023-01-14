{
  const handleSubmitForm = e => {
    const $form = e.currentTarget;
    if (!$form.checkValidity()) {
      e.preventDefault();
      const inputs = document.querySelectorAll(`.input`);
      inputs.forEach($input => showValidationInfo($input));
    }
  }

  const handleInputField = e => {
    const $input = e.currentTarget;
    const $error = $input.parentElement.querySelector(`.error`);
    if($input.checkValidity()){
      $error.textContent = ``;
    }
  };

  const showTypeMismatch = type => {
    switch (type) {
      case `email`:
        return `e-mailadres`;
      case `url`:
        return `website url`;
      case `tel`:
        return `telephone nr`;
    }
  }

  const showValidationInfo = $input => {
    // selecting the error element of each element
    const $error = $input.parentElement.querySelector(`.error`);

    // check if the field is filled out
    if ($input.validity.valueMissing) {
      $error.textContent = `This field is mandatory`;
    }
    // check if the input type matches
    if ($input.validity.typeMismatch) {
      $error.textContent = `We're expecting a valid ${showTypeMismatch($input.getAttribute(`type`))}`;
    }
    // check if the input length isn't too long
    if ($input.validity.tooLong) {
      $error.textContent = `Please enter no more than ${$input.getAttribute(`maxlength`)} characters`;
    }
    // check if the minimum input length is reached
    if ($input.validity.tooShort) {
      $error.textContent = `Please enter at least ${$input.getAttribute(`minlength`)} characters`;
    }
    // check if the numeric input value is larger / equal than the expected minimum
    if ($input.validity.rangeUnderflow) {
      $error.textContent = `The value needs to be at least ${$input.getAttribute(`min`)}`;
    }
    // check if the numeric input value is smaller / equal than the expected minimum
    if ($input.validity.rangeOverflow) {
      $error.textContent = `The value needs to be less than ${$input.getAttribute(`max`)}`;
    }
  }

  const handleBlurInput = e => {
    showValidationInfo(e.currentTarget);
  };

  const init = () => {
    const $form = document.querySelector(`form`);
    $form.noValidate = true;
    $form.addEventListener(`submit`, handleSubmitForm);

    const inputs = document.querySelectorAll(`input`);
    inputs.forEach($input => {
      $input.addEventListener(`blur`, handleBlurInput);
      $input.addEventListener(`input`, handleInputField);
    });
  };

  init();
}