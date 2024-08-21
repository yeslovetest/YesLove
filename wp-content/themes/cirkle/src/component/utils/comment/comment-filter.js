import app from '../../../helper/core';

const  { filterString, wrapLinks, limitLineBreaks, replaceEnterWithBr } = app;
const lineBreakLimit = 6;//vikinger_constants.settings.activity_line_break_limit || ;

const filterCommentContentForSave = (string) => {
  return filterString(string.trim(), [{filterFN: limitLineBreaks, filterArgs: [lineBreakLimit]}]);
};

const filterCommentContentForDisplay = (string) => {
  return filterString(string.trim(), [wrapLinks, {filterFN: limitLineBreaks, filterArgs: [lineBreakLimit]}, replaceEnterWithBr]);
};

export {
  filterCommentContentForSave,
  filterCommentContentForDisplay
};