@mod @mod_facetoface @totara
Feature: Seminar timezones in reports
  In order to no confuse users with timezones
  As an administrator
  I need to be able to disable seminar timezones in report

  @javascript @totara_customfield
  Scenario: Test timezones in seminar sessions report
    Given I am on a totara site
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | user1    | First     | User     | user1@example.com    |
      | user2    | Second    | User     | user2@example.com    |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user  | course | role    |
      | user1 | C1     | student |
      | user2 | C1     | student |
    And the following "standard_report" exist in "totara_reportbuilder" plugin:
      | fullname     | shortname           | source              |
      | F2F sessions | report_f2f_sessions | facetoface_sessions |

    And I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add a "Seminar" to section "1" and I fill the form with:
      | Name        | Test seminar name        |
      | Description | Test seminar description |
    And I follow "Test seminar name"
    And I follow "Add event"
    And I click on "Edit session" "link"
    And I set the following fields to these values:
      | sessiontimezone      | Europe/Prague   |
      | timestart[day]       | 2               |
      | timestart[month]     | 1               |
      | timestart[year]      | ## next year ## Y ## |
      | timestart[hour]      | 1               |
      | timestart[minute]    | 15              |
      | timestart[timezone]  | Australia/Perth |
      | timefinish[day]      | 2               |
      | timefinish[month]    | 1               |
      | timefinish[year]     | ## next year ## Y ## |
      | timefinish[hour]     | 3               |
      | timefinish[minute]   | 45              |
      | timefinish[timezone] | Australia/Perth |
    And I click on "OK" "button" in the "Select date" "totaradialogue"

    And I click on "Select rooms" "link"
    And I click on "Create" "link"
    And I set the following fields to these values:
      | Name             | Room 1          |
      | id_roomcapacity  | 10              |
      | Building         | Building 123    |
      | Address          | 123 Tory street |
    # It doesn't click when asked just once.
    And I click on "#id_customfield_locationsize_medium" "css_element"
    And I click on "#id_customfield_locationsize_medium" "css_element"
    And I click on "#id_customfield_locationview_satellite" "css_element"
    And I click on "#id_customfield_locationdisplay_map" "css_element"
    And I click on "#id_customfield_locationdisplay_map" "css_element"
    And I press "Use Address"
    And I click on "//div[@aria-describedby='editcustomroom0-dialog']//div[@class='ui-dialog-buttonset']/button[contains(.,'OK')]" "xpath_element"

    And I press "Save changes"
    And I follow "Add event"
    And I click on "Edit session" "link"
    And I set the following fields to these values:
      | sessiontimezone      | User timezone   |
      | timestart[day]       | 4               |
      | timestart[month]     | 2               |
      | timestart[year]      | ## 2 years ## Y ## |
      | timestart[hour]      | 1               |
      | timestart[minute]    | 0               |
      | timestart[timezone]  | Australia/Perth |
      | timefinish[day]      | 4               |
      | timefinish[month]    | 2               |
      | timefinish[year]     | ## 2 years ## Y ## |
      | timefinish[hour]     | 2               |
      | timefinish[minute]   | 30              |
      | timefinish[timezone] | Australia/Perth |
    And I click on "OK" "button" in the "Select date" "totaradialogue"

    And I click on "Select rooms" "link"
    And I click on "Create" "link"
    And I set the following fields to these values:
      | Name             | Room 2          |
      | id_roomcapacity  | 10              |
      | Building         | Building 123    |
      | Address          | 123 Tory street |
    # It doesn't click when asked just once.
    And I click on "#id_customfield_locationsize_medium" "css_element"
    And I click on "#id_customfield_locationsize_medium" "css_element"
    And I click on "#id_customfield_locationview_satellite" "css_element"
    And I click on "#id_customfield_locationdisplay_map" "css_element"
    And I click on "#id_customfield_locationdisplay_map" "css_element"
    And I press "Use Address"
    And I click on "//div[@aria-describedby='editcustomroom0-dialog']//div[@class='ui-dialog-buttonset']/button[contains(.,'OK')]" "xpath_element"

    And I press "Save changes"
    And I should see "6:15 PM - 8:45 PM" in the "Room 1" "table_row"
    And I should see "Timezone: Europe/Prague" in the "Room 1" "table_row"
    And I should see date "1 Jan next year Australia/Perth" formatted "%d %B %Y" in the "Room 1" "table_row"
    And I should see "1:00 AM - 2:30 AM" in the "Room 2" "table_row"
    And I should see "Timezone: Australia/Perth" in the "Room 2" "table_row"
    And I should see date "4 Feb +2 years Australia/Perth" formatted "%d %B %Y" in the "Room 2" "table_row"
    And I click on the seminar event action "Attendees" in row "Room 1"
    And I set the field "Attendee actions" to "Add users"
    And I set the field "potential users" to "First User, user1@example.com"
    And I press exact "add"
    And I press "Continue"
    And I press "Confirm"
    And I wait until "First User" "text" exists
    And I click on "View all events" "link"
    And I click on the seminar event action "Attendees" in row "Room 2"
    And I set the field "Attendee actions" to "Add users"
    And I set the field "potential users" to "Second User, user2@example.com"
    And I press exact "add"
    And I press "Continue"
    And I press "Confirm"
    And I wait until "Second User" "text" exists

    And I navigate to my "F2F sessions" report
    And I press "Edit this report"
    And I switch to "Columns" tab
    And I add the "Session Finish Date/Time" column to the report
    And I add the "Session Start Date/Time (linked to activity)" column to the report

    When I navigate to my "F2F sessions" report
    And I should see date "1 Jan next year Australia/Perth" formatted "%d %B %Y" in the "First User" "table_row"
    And I should see "6:15 PM" in the "First User" "table_row"
    And I should see "Timezone: Europe/Prague" in the "6:15 PM" "table_row"
    And I should see "8:45 PM" in the "First User" "table_row"
    And I should see "Timezone: Europe/Prague" in the "8:45 PM" "table_row"
    And I should see date "4 Feb +2 years Australia/Perth" formatted "%d %B %Y" in the "Second User" "table_row"
    And I should see "1:00 AM" in the "Second User" "table_row"
    And I should see "Timezone: Australia/Perth" in the "1:00 AM" "table_row"
    And I should see "2:30 AM" in the "Second User" "table_row"
    And I should see "Timezone: Australia/Perth" in the "2:30 AM" "table_row"
    And I should not see "2 January"

    When I am on homepage
    And I set the following administration settings values:
      | facetoface_displaysessiontimezones | 0 |
    And I navigate to my "F2F sessions" report
    # That's a bit strange that w/o timezone date shown in different format, might need to look at that later.
    Then I should see "2 Jan" in the "First User" "table_row"
    Then I should see date "2 Jan next year 1:15 AM Australia/Perth" formatted "%Y" in the "First User" "table_row"
    And I should see "1:15" in the "First User" "table_row"
    And I should see "3:45" in the "First User" "table_row"
    And I should see "4 Feb" in the "Second User" "table_row"
    And I should see date "4 Feb +2 years 1:00 AM Australia/Perth" formatted "%Y" in the "Second User" "table_row"
    And I should see "1:00" in the "Second User" "table_row"
    And I should see "2:30" in the "Second User" "table_row"
    And I should not see "Prague"
    And I should not see "Perth"
    And I should not see "1 January"

  @javascript
  Scenario: Test timezones in seminar summary report
    Given I am on a totara site
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "standard_report" exist in "totara_reportbuilder" plugin:
      | fullname    | shortname          | source             |
      | F2F summary | report_f2f_summary | facetoface_summary |

    And I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add a "Seminar" to section "1" and I fill the form with:
      | Name        | Test seminar 1 name        |
      | Description | Test seminar 1 description |
    And I follow "Test seminar 1 name"
    And I follow "Add event"
    And I click on "Edit session" "link"
    And I set the following fields to these values:
      | sessiontimezone      | Europe/Prague   |
      | timestart[day]       | 2               |
      | timestart[month]     | 1               |
      | timestart[year]      | ## next year ## Y ## |
      | timestart[hour]      | 1               |
      | timestart[minute]    | 15              |
      | timestart[timezone]  | Australia/Perth |
      | timefinish[day]      | 2               |
      | timefinish[month]    | 1               |
      | timefinish[year]     | ## next year ## Y ## |
      | timefinish[hour]     | 3               |
      | timefinish[minute]   | 45              |
      | timefinish[timezone] | Australia/Perth |
    And I click on "OK" "button" in the "Select date" "totaradialogue"
    And I press "Save changes"
    And I am on "Course 1" course homepage
    And I add a "Seminar" to section "1" and I fill the form with:
      | Name        | Test seminar 2 name        |
      | Description | Test seminar 2 description |
    And I follow "Test seminar 2 name"
    And I follow "Add event"
    And I click on "Edit session" "link"
    And I set the following fields to these values:
      | sessiontimezone      | User timezone   |
      | timestart[day]       | 4               |
      | timestart[month]     | 2               |
      | timestart[year]      | ## 2 years ## Y ## |
      | timestart[hour]      | 1               |
      | timestart[minute]    | 0               |
      | timestart[timezone]  | Australia/Perth |
      | timefinish[day]      | 4               |
      | timefinish[month]    | 2               |
      | timefinish[year]     | ## 2 years ## Y ## |
      | timefinish[hour]     | 2               |
      | timefinish[minute]   | 30              |
      | timefinish[timezone] | Australia/Perth |
    And I click on "OK" "button" in the "Select date" "totaradialogue"
    And I press "Save changes"

    And I navigate to my "F2F summary" report
    And I press "Edit this report"
    And I switch to "Columns" tab
    And I add the "Session Start Date/Time (linked to activity)" column to the report

    When I navigate to my "F2F summary" report
    Then I should see date "1 Jan next year Europe/Prague" formatted "%d %B %Y" in the "Test seminar 1 name" "table_row"
    And I should see date "4 Feb +2 years Australia/Perth" formatted "%d %B %Y" in the "Test seminar 2 name" "table_row"
    And I should see "Europe/Prague" in the "Test seminar 1 name" "table_row"
    And I should see "Australia/Perth" in the "Test seminar 2 name" "table_row"
    And I should not see "2 January"

    When I am on homepage
    And I set the following administration settings values:
      | facetoface_displaysessiontimezones | 0 |
    And I navigate to my "F2F summary" report
    Then I should see "2 Jan" in the "Test seminar 1 name" "table_row"
    Then I should see date "2 Jan next year" formatted "%Y" in the "Test seminar 1 name" "table_row"
    And I should see "4 Feb" in the "Test seminar 2 name" "table_row"
    And I should see date "4 Feb +2 years" formatted "%Y" in the "Test seminar 2 name" "table_row"
    And I should not see "Prague"
    And I should not see "Perth"
    And I should not see "1 January"
