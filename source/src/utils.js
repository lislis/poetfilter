export function hasFilter(columnName) {
  const allowList = window.poetfilterData.cols2Filter;
  return allowList.includes(columnName);
}


export function isAlpha(pred) {
  return pred == "true" ? "☑️" : "";
}

export function hasWebsite(pred) {
  return pred != "" ? `<a href="${pred}" target="_blank" rel="nofollow">website</a>` : "";
}

export function hasInsta(pred) {
  return pred != "" ? `Instagram <a href="https://instagram.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}

export function hasX(pred) {
  return pred != "" ? `X <a href="https://x.com/${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}

export function hasTiktok(pred) {
  return pred != "" ? `TikTok <a href="https://tiktok.com/@${pred}" target="_blank" rel="nofollow">@${pred}</a>` : "";
}

export function fieldFormating(colName, value) {
  let out = "";
  switch(colName) {
  case 'alpha':
    out = isAlpha(value);
    break;
  case 'website':
    out = hasWebsite(value);
    break;
  case 'instagram':
    out = hasInsta(value);
    break;
  case 'twitter':
    out = hasX(value);
    break;
  case 'tiktok':
    out = hasTiktok(value);
    break;
  }

  return out;
}

export function formatJobs(value) {
  if (value == "[]") return;
   
  const dict = {
    0: "Poet*in",
    1: "Veranstalter*in",
    2: "Moderator*in",
    3: "Featured Artist"
  }

  try {
    return JSON.parse(value)
      .filter(x => x.length >= 1)
      .map(x => dict[x]).join(", ")  
  } catch {
    console.log(value)
  }
  
}
