import plugins from '../helper/plugins';

plugins.createTooltip({
  container: '.text-tooltip-tfr',
  offset: 4,
  direction: 'right',
  animation: {
    type: 'translate-in-fade'
  }
});

plugins.createTooltip({
  container: '.text-tooltip-tft',
  offset: 4,
  direction: 'top',
  animation: {
    type: 'translate-out-fade'
  }
});