export function hasFilter(columnName) {
  const allowList = window.poetfilterData.cols2Filter;
  return allowList.includes(columnName);
}


export function isAlpha(pred) {
  return pred == "true" ? "☑️" : "";
}

export function hasWebsite(pred) {
  return pred != "" ? `<a href="${pred}" target="_blank" rel="nofollow">🌐</a>` : "";
}

export function hasInsta(pred) {
  return pred != "" ? `<a href="https://instagram.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}

export function hasX(pred) {
  return pred != "" ? `<a href="https://x.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}

export function hasTiktok(pred) {
  return pred != "" ? `<a href="https://tiktok.com/@${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}
