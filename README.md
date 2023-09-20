# Good saver

## Run the project, run the following commands:
1. docker-compose up -d
2. docker exec -it {id container good_project_php} php bin/console cache:clear
3. docker exec -it {id container good_project_php} composer install
4. docker exec -it {id container good_project_php} php bin/console doctrine:migrations:migrate
5. docker exec -it {id container good_project_php} php bin/console doctrine:migrations:migrate --env=test
