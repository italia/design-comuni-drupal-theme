const $wrapper = document.querySelector('.view-display-id-risultati');

if ($wrapper){
  const params = new URLSearchParams(window.location.search)

  if (params.has('search_api_fulltext')) {
    $wrapper.querySelector('#search_api_fulltext').value = params.get('search_api_fulltext')
  }
}
