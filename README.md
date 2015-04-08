# WP-vs-CMSMS

Article transfert between **CMS Made Simple** (CMSMS) and **WordPress** (WP)

> **This is a study of how to transfert articles from a CMS to the other one. It's NOT finnished, it's PROGRESSING. I'll use this page as a report untill i have a final solution.**

## From CMSMS to WP

### 0 - Context

Start with an "old" CMSMS full of articles
Start with a fresh WP empty

Both use a MySQL DB storage.

### 1 - Extraction of DataBase tables

from CMSMS :
- cms_module_news.sql
- cms_module_news_categories.sql
- cms_module_news_fielddefs.sql
- cms_module_news_fieldvals.sql
- cms_users.sql

from WP :
- wp_posts.sql
- wp_term_relationships.sql
- wp_term_taxonomy.sql
- wp_terms.sql

It looks like to be the most important tables to look at. Maybe some wont be needed.

I did a small php script to get datas from WP DB.

Next steps are :
- Read both WP and CMSMS DB
- Write into WP and CMSMS DB
- Analyse both table to find links
- Configure the script to copy from a DB into the other DB 

Warning :
- Check relative url of pics

To include :
- How to make DB save from MySQL

---

> by undless
