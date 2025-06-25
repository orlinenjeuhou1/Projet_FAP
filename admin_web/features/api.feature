@api
Feature: API Endpoints
  As a client application
  I want to access the API endpoints
  So that I can retrieve and manage data

  Background:
    Given I am on "/api"

  Scenario: Get countries list
    When I send a GET request to "/api/countries"
    Then the response status code should be 200
    And the response should contain JSON

  Scenario: Get guides list
    When I send a GET request to "/api/guides"
    Then the response status code should be 200
    And the response should contain JSON

  Scenario: Get locations list
    When I send a GET request to "/api/locations"
    Then the response status code should be 200
    And the response should contain JSON

  Scenario: Get visits list
    When I send a GET request to "/api/visits"
    Then the response status code should be 200
    And the response should contain JSON

  Scenario: Authentication required for protected endpoints
    When I send a GET request to "/api/admin/users"
    Then the response status code should be 401
