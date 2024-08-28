# nette-active-row
Demo of ActiveRow problems.

- To start, run: `docker compose up`.
- You can change settings, such as the number of rows (= `BATCH_SIZE`), in `bootstrap.local.php`.
- Test URLs:
    - http://127.0.0.1/related.php (uses ActiveRow::related())
    - http://127.0.0.1/related-optimised.php (uses manually constructed SQL)