@core @core_user
Feature: Hidden user fields behavior
  In order to hide private information of users
  As an admin
  I can set Hide user fields setting

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email               | description | city     |
      | user     | Profile   | User     | user@example.com    | This is me  | Donostia |
      | student  | Student   | User     | student@example.com |             |          |
      | teacher  | Teacher   | User     | teacher@example.com |             |          |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | user    | C1     | student        |
      | student | C1     | student        |
      | teacher | C1     | editingteacher |
    And the following config values are set as admin:
      | hiddenuserfields | description |
    And the following "permission overrides" exist:
      | capability                    | permission | role           | contextlevel | reference |
      | moodle/user:viewhiddendetails | Allow      | editingteacher | Course       | C1        |

  Scenario Outline: Hidden user fields on course context profile based on role permission
    Given I log in as "<user>"
    And I am on "Course 1" course homepage
    And I navigate to course participants
    And I should see "Profile User"
    And I click on "Profile User" "link" in the "#participants" "css_element"
    Then I <expected> "This is me"
    And I should see "Donostia"

    Examples:
      | user    | expected       |
      | student | should not see |
      | teacher | should see     |
      | admin   | should see     |