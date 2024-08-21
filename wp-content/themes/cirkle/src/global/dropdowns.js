import plugins from '../helper/plugins';

/**
 * HEADER SETTINGS
 */
plugins.createDropdown({
  trigger: '.header-settings-dropdown-trigger',
  container: '.header-settings-dropdown',
  offset: {
    top: 64,
    right: 22
  },
  animation: {
    type: 'translate-top'
  }
});