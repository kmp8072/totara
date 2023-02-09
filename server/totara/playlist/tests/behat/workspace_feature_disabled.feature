@totara_playlist @totara @totara_engage @javascript @engage
Feature: Workspaces should not be mentioned on playlists when the feature is disabled

  Background:
    Given I am on a totara site
    And I set the site theme to "ventura"
    And I enable the "container_workspace" advanced feature
    And the following "users" exist:
      | username | firstname | lastname | email             |
      | user1    | User      | One      | user1@example.com |
      | user2    | User      | Two      | user1@example.com |
    And the following "topics" exist in "totara_topic" plugin:
      | name   |
      | Topic1 |
    And the following "workspaces" exist in "container_workspace" plugin:
      | name             | summary   | owner | topics |
      | Test Workspace 1 | Workspace | user1 | Topic1 |
    And the following "playlists" exist in "totara_playlist" plugin:
      | name            | username | access | topics |
      | Test Playlist 1 | user1    | PUBLIC | Topic1 |

  @javascript
  Scenario: Should not see workspaces when owner is sharing a resource
    Given I log in as "user1"

    When I view playlist "Test Playlist 1"
    And I click on "Share playlist" "button"
    And I wait for the next second
    Then I should see "Share to specific people or workspaces (optional)"

    When I disable the "container_workspace" advanced feature
    When I view playlist "Test Playlist 1"
    And I click on "Share playlist" "button"
    And I wait for the next second
    Then I should see "Share to specific people"
    And I should not see "Share to specific people or workspaces (optional)"

  @javascript
  Scenario: Should not see workspaces when another user is sharing a resource
    Given I log in as "user2"

    When I view playlist "Test Playlist 1"
    And I click on "Reshare playlist" "button"
    And I wait for the next second
    Then I should see "Reshare to specific people or workspaces"

    When I disable the "container_workspace" advanced feature
    When I view playlist "Test Playlist 1"
    And I click on "Reshare playlist" "button"
    And I wait for the next second
    Then I should see "Reshare to specific people"
    And I should not see "Share to specific people or workspaces"