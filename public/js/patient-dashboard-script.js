let content_page = document.getElementsByClassName("content")
let sidebar_link = document.getElementsByClassName("sidebar-link")
let profile_card = document.getElementsByClassName("profile-card-container")

function show_corresponding_content(id)
{
    for(let index=0;index<5;index++)
    {
        if(index === id)
        {
            content_page[index].style = ""
        }
        else
        {
            content_page[index].style = "display: none"
        }
    }
}

var profile_card_appearance = false

function toggle_profile_card()
{
    profile_card_appearance = !profile_card_appearance
    if(profile_card_appearance === true)
    {
        profile_card[0].style = "display: flex"
    }
    else
    {
        profile_card[0].style = "display: none"
    }
}

for(let index=0;index<5;index++)
{
    sidebar_link[index].onclick = () => {
        show_corresponding_content(index)
    }
}