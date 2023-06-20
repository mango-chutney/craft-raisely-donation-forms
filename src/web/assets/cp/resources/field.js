(function ($) {
  Craft.RaiselyForms = Garnish.Base.extend({
    id: null,
    init: function (id) {
      const button = document.getElementById(id);
      const data = document.getElementById(id + '-data');
      const spinner = document.getElementById(id + '-spinner');
      const check = document.getElementById(id + '-check');
      const error = document.getElementById(id + '-errors');
      const warning = document.getElementById(id + '-warning');

      button.addEventListener('click', async function () {
        if (!button.classList.contains('disabled')) {
          spinner.classList.remove('hidden');
          check.classList.add('hidden');
          button.classList.add('disabled');
          error.classList.add('hidden');
          data.classList.add('disabled');

          const get = await fetch(
            '/actions/raisely-donation-forms/forms/refresh-cache',
            {
              headers: {
                Accept: 'application/json',
              },
            }
          );

          const response = await get.json();

          if (response.error) {
            error.classList.remove('hidden');
            error.firstChild.textContent = response.error;
          }

          if (!response.error) {
            const selected = data.options[data.selectedIndex].value;
            Array.from(data).forEach((option) => {
              data.removeChild(option);
            });

            const options = [['Select a form', 'null']];

            response.forms.data.forEach((element) => {
              options.push([element.name, element.path]);
            });

            options.map((optionData) => {
              var opt = document.createElement('option');
              opt.appendChild(document.createTextNode(optionData[0]));
              opt.value = optionData[1];
              data.appendChild(opt);
            });

            Array.from(data.options).forEach((option) => {
              if (option.value === selected) {
                option.selected = true;
              }
            });

            data.parentElement.classList.remove('hidden');
            check.classList.remove('hidden');
            if (warning) {
              warning.classList.add('hidden');
            }
          }

          button.classList.remove('disabled');
          data.classList.remove('disabled');
          spinner.classList.add('hidden');
        }
      });
    },
  });
})(jQuery);
