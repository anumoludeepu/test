Feature: Testing Hero Character API

  Scenario: get list of heroes
    Given I want to send a "GET" request
    And I set "Authorization" header to "War warpass"
    When I request "/char/characters.json"
    Then  the response is JSON
    And response contain "3" elements
    And the response has a "id" property in list
    And the response has a "name" property in list
    And the response has a "hp" property in list
    And the response has a "def" property in list
    And the response has a "exp" property in list
    And the response has a "base_hp" property in list
    And the response has a "skills[0].id" property in list
    And the response has a "skills[0].skill" property in list
    And the response has a "fight_history" property in list

  Scenario: create hero
    Given body of request contains json
    """
    {
      "name": "testCreateHero",
      "password":"test",
      "type": "Mage"
    }
    """
    When I send "POST" request to "/char/characters.json"
    And I should see response status code 201
    And I set "Authorization" header to "testCreateHero test"
    Then I send "GET" request to "/char/characters/4.json"
    And the response is JSON
    And the response has a "id" property
    And the response has a "name" property with "testCreateHero" value

  Scenario: hero fight enemy
    Given I want to send a "PATCH" request
    And I set "Authorization" header to "War warpass"
    When I request "/char/fights/2/enemies/1/character.json"
    Then  the response is JSON
    And the response has a "id" property
    And the response has a "name" property
    And the response has a "hp" property
    And the response has a "fight_history[0].id" property
    And the response has a "fight_history[0].time_start" property
    And the response has a "fight_history[0].time_finish" property
    And the response has a "fight_history[0].dmg_affected" property
    And the response has a "fight_history[0].dmg_received" property
    And the response has a "fight_history[0].type" property with "hero" value

