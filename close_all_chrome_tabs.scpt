tell application "Google Chrome"
    set windowList to every tab of every window whose (URL does not start with "http://localhost/jeffrey/index.php")
    repeat with tabList in windowList
        repeat with thisTab in tabList
            close thisTab
        end repeat
    end repeat
end tell