# Custom Theme

# Hotel Association of Canada
Custom WordPress Theme for build for this site (https://hotelassociation.ca/).

## Table of Contents
1. [Setup](#setup)

## Setup

### Project Setup
[Standard Project Setup](http://dev-wiki.operaticsites.com/en/wordpress/standard-project-setup)

- This project relies on Advanced Custom Fields (ACF) to add reusuable modules to pages for formatting content.
- Each module has a single php file under `/wp-content/themes/operatic/includes/components/` and their filenames must match their module layout names in ACF.
- Each module has its own scss file as well under `/wp-content/themes/operatic/includes/components/` and must be referenced in `style.scss`
- All pages use the `page.php` template.
- For pages that just have content, `includes/components.php` is invoked.

---
Qasid Saleh
