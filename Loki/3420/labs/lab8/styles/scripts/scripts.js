/* Every line that has "--- *" commented onto the end of them is correct, and
 * does not need to be modified. This does not mean every other line is
 * incorrect, however; we're just clarifying the weird ones for you. */

// -------------------------------------------------------------------------- //

/* This function creates an array of numbers, then copies the even ones into a
 * new array, which is then returned. */
function getEvenNumbers() {
    const numbers = [21, 42, 62, 65, 76, 87, 108];
    const evenNumbers = [];
    for (i = 0; i < numbers.length; i++) {
      if (numbers[i] % 2 == 0) {
        evenNumbers.push(numbers[i]);
      }
    }
  
    return evenNumbers;
  }
  
  /* This function *accepts* an array of numbers and outputs them to the console
   * one by one. */
  function displayNumbers(evenNumbers) {
    for (let i = 0; i < evenNumbers.length; i++) {
      console.log(evenNumbers[i]);
    }
  }
  
  window.addEventListener('DOMContentLoaded', event => { // --- *
  
    displayNumbers(getEvenNumbers());
  
  }); // --- *