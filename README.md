# Table Vertical Align
Simple plugin to configure vertical-align in tables

DokuWiki homepage at https://www.dokuwiki.org/plugin:vertical  

Cross-plugin compatibility is outside the scope of this repo.

If reporting bugs, please provide a valid reproduction scenario for any non-trivial case.

## Usage
After installing the plugin you should make sure that your DokuWiki cache is updated. This can easily be done by changing any parameter value in settings (or by doing a `touch conf/local.php`).

You need to set `<vertical head=align body=align>` and `</vertical>` tags around your table, where `align` can be:

* top - sets vertical-align to `top`
* center - sets vertical-align to `middle`
* bottom - sets vertical-align to `bottom`

```
<vertical head=bottom body=center>
^ **Number**  ^ **Some column**  ^ **Date**    ^
| 1           | one              | 2023-04-01  |
| 2           | two              | 2023-04-02  |
</vertical>
```
