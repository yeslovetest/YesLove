import app from '../helper/core';

app.querySelector('.page-loader', function (el) {
  const pageLoader = el[0];

  const hidePageLoader = function () {
    pageLoader.classList.add('hidden');
  };
  
  window.addEventListener('load', hidePageLoader);
});