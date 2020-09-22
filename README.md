# About

This module extends the SiteInformationForm to add a Site API Key. It provides a custom url which returns the JSON response of a page only if Site API Key is provided as a url prameter. 

## Usage
Go to the url <base_url>/page_json/{site_api_key}/{node_id}
The site API key can be entered at the URL /admin/config/system/site-information

## Process and References
1. lando drupal generate:module // axl_page_json
2. lando drupal generate:config:form // Changed the code to extend SiteInformationForm and not ConfigFormBase
3. lando drupal generate:routesubscriber // Alter system.site_information_settings to use Custom SiteInformationForm created in previous step.
4. lando drupal generate:controller // PageJsonController::page for route /page_json/{site_api_key}/{node_id}
5. Return serialized page or access denied. https://drupal.stackexchange.com/a/191474 --> How to serialize.
1. Total time to complete: Around 1 hour
