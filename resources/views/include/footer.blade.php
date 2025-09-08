  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <sb-customizer project="sb-admin-pro"></sb-customizer>
  <script>
      window.addEventListener('DOMContentLoaded', event => {
          const litepickerRangePluginele = document.getElementById('litepickerRangePlugin');
          if (litepickerRangePluginele) {
              new Litepicker({
                  element: litepickerRangePluginele,
                  startDate: '{{ $date_from ?? '' }}',
                  endDate: '{{ $date_to ?? '' }}',
                  singleMode: false,
                  numberOfMonths: 2,
                  numberOfColumns: 2,
                  format: 'MMM DD, YYYY',
                  plugins: ['ranges'],
                  setup: (picker) => {
                      picker.on('selected', (date1, date2) => {
                          console.log(date1)
                          console.log(date2)
                          let dateFrom = date1.format('YYYY-MM-DD');
                          let dateTo = date2.format('YYYY-MM-DD');
                          let url = new URL(window.location.href);
                          url.searchParams.set('date_from', dateFrom);
                          url.searchParams.set('date_to', dateTo);
                          window.location.href = url.toString();
                      });
                  },
              });
          }
      })

      function validateForm(event, form, id) {
          event.preventDefault();
          var inputs = form.querySelectorAll('input');
          var selects = form.querySelectorAll('select');
          var isValid = true;
          selects.forEach(function(select) {
              if ((!select.value || select.value === '') && select.classList.contains('required')) {
                  select.classList.add('error');
                  isValid = false;
                  field_name = getFormatedname(select)
                  removeErrorMessage(select);
                  createErrorMessage(select, field_name + ' is required.');
              } else {
                  removeErrorMessage(select);
                  select.classList.remove('error');
              }
          })
          inputs.forEach(function(input) {
              if (input.value.trim() === '' && input.classList.contains('required')) {
                  input.classList.add('error');
                  isValid = false;
                  field_name = getFormatedname(input)
                  removeErrorMessage(input);
                  createErrorMessage(input, field_name + ' is required.');
              } else {
                  if (input.name == 'email') {
                      if (!emailValidations(input, input.name, input.value.trim(), '1')) {
                          isValid = false;
                      }
                  } else {
                      input.classList.remove('error');
                      removeErrorMessage(input);
                  }
              }
          });
          if (isValid) {
              // event.target.submit();
              submitformRequest(form)


          }
      }

      function submitformRequest(form) {
          // prepare data
          const formData = new FormData(form);
          fetch(form.action, {
                  method: form.method,
                  body: formData,
                  headers: {
                      'X-Requested-With': 'XMLHttpRequest',
                      'Accept': 'application/json'
                  }
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      if (data.redirect) {
                          window.location.href = data.redirect; // redirect if backend sends URL
                      } else {
                          alert(data.message || "Success!");
                      }
                  } else {
                      // show validation errors
                      if (data.errors) {
                          for (let field in data.errors) {
                              let input = form.querySelector(`[name="${field}"]`);
                              if (input) {
                                  removeErrorMessage(input);
                                  createErrorMessage(input, data.errors[field][0]);
                              }
                          }
                      } else {
                          alert(data.message || "Something went wrong");
                      }
                  }
              })
              .catch(error => {
                  console.error("Error:", error);
                  alert("Server error, please try again later.");
              });
      }

      function confirmDelete(url, id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "Do you really want to delete this item?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  deleteItem(`${url}`);
              }
          });
      }

      function previewImage(event) {
          var reader = new FileReader();
          console.log(reader.result)
          reader.onload = function() {

              var output = document.getElementById('profile-image');
              output.src = reader.result;
          };
          reader.readAsDataURL(event.target.files[0]);
      }

      function deleteItem(url) {
          fetch(`${url}`, {
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                      'Accept': 'application/json'
                  }
              })
              .then(response => response.json())
              .then(data => {
                  Swal.fire(
                      'Deleted!',
                      'Your item has been deleted.',
                      'success'
                  ).then(() => {
                      location.reload();
                  });
              })
              .catch(error => {
                  Swal.fire(
                      'Error!',
                      'There was a problem deleting the item.',
                      'error'
                  );
              });
      }

      function attachOnChangeToInputsSelects() {
          // Get all the input elements on the page
          var inputs = document.getElementsByTagName('input');
          var selects = document.getElementsByTagName('select');

          // Iterate over each input field
          for (var i = 0; i < inputs.length; i++) {
              // Attach the onchange event handler to the current input field
              // inputs[i].addEventListener('change', handleInputChange);
              // inputs[i].addEventListener('input', handleInputInput);
          }
          for (var i = 0; i < selects.length; i++) {
              // Attach the onchange event handler to the current input field
              selects[i].addEventListener('change', handleSelectChange);
              // selects[i].addEventListener('input', handleSelectInput);
          }
      }
      attachOnChangeToInputsSelects();

      function handleSelectChange(event) {
          var select = event.target;
          var value = select.value;
          var name = select.getAttribute('name');

          // Remove any non-numeric characters

          if (name === 'role_id') {
              var districtDiv = document.querySelector('.district-div');
              var entrypointDiv = document.querySelector('.entrypoints-div');

              if (value == 5) {
                  districtDiv.style.display = "block";
                  entrypointDiv.style.display = "block";
              } else if (value == 4) {
                  districtDiv.style.display = "block";
                  entrypointDiv.style.display = "none";
              } else if (value == 2 || value == 3) {
                  districtDiv.style.display = "none";
                  entrypointDiv.style.display = "none";
              } else {
                  districtDiv.style.display = "none";
                  entrypointDiv.style.display = "none";
              }
          }

      }

      function fetchonChangeSelect(select, updateSelect, routeName) {
          let url = routeMap[routeName].replace(':id', select.value);
          fetch(url)
              .then(response => response.json())
              .then(data => {
                  if (updateSelect.name == 'tehsil_id') {
                      updateSelect.innerHTML = '<option value="">Select Tehsil</option>';
                      data.forEach(tehsil => {
                          updateSelect.innerHTML +=
                              `<option value="${tehsil.id}">${tehsil.name} / ${tehsil.name_ur}</option>`;
                      });
                  }
                  if (updateSelect.name == 'business_sub_category_id') {
                      updateSelect.innerHTML = '<option value="">Select Subcategory</option>';
                      data.forEach(sub => {
                          updateSelect.innerHTML +=
                              `<option value="${sub.id}">${sub.name}</option>`;
                      });
                      updateSelect.innerHTML += `<option value="100">Others</option>`
                  }
                  if (updateSelect.name == 'applicant_choosed_branch') {
                      updateSelect.innerHTML = '<option value="">Select Branches</option>';
                      data.forEach(sub => {
                          updateSelect.innerHTML +=
                              `<option value="${sub.id}">${sub.branch_code} ${sub.branch_name}</option>`;
                      });
                  }
              });
      }

      function createErrorMessage(input, message) {
          const formGroupParent = input.closest('.form-group');
          if (!formGroupParent) return;

          // Check if an error div already exists
          let errorDiv = formGroupParent.querySelector('.input-error-div');

          if (!errorDiv) {
              errorDiv = document.createElement('div');
              errorDiv.className = 'input-error-div';
              errorDiv.style.color = '#f00'; // red error text
              errorDiv.style.fontSize = '13px';
              errorDiv.style.marginTop = '5px';
              formGroupParent.appendChild(errorDiv);
          }

          errorDiv.textContent = message;
          errorDiv.style.display = 'block';
      }

      function removeErrorMessage(input) {
          const inputGroupParent = input.closest('.input-group')?.parentElement;
          if (!inputGroupParent) return;

          const errorDiv = inputGroupParent.querySelector('.input-error-div');
          if (errorDiv) {
              errorDiv.textContent = '';
              errorDiv.style.display = 'none';
          }
      }

      function emailValidations(input, elemName, elemeValue) {
          if (elemeValue.trim() !== '') {
              var advanceRegex =
                  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/;
              if (/(.+)@(.+){2,}\.(.+){2,}/.test(elemeValue.trim()) && advanceRegex.test(elemeValue.trim())) {
                  input.classList.remove('error');
                  // removeErrorComponent(e);
                  return true
              } else {
                  //    removeErrorComponent(e);
                  // createErrorComponent(e, 'Must be a valid email.', 'example@yourdomain.com');
                  showToast("Please Enter a valid email", "left", "bottom");
                  input.classList.add('error');
                  return false
              }
          }
      }

      function getFormatedname(elm) {
          if (elm.hasAttribute('data-name')) return elm.getAttribute('data-name');
          return formatFieldName(elm.name)

      }

      function formatFieldName(fieldName) {
          let words;
          if (fieldName.includes('_')) {
              words = fieldName.split('_');
          } else {
              words = [fieldName];
          }
          let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
          let formattedName = capitalizedWords.join(' ');
          return formattedName;
      }
  </script>
