Feature: API basic test

  Scenario: The API is up
    Given I am on "/api"
    Then the response status code should be 200
