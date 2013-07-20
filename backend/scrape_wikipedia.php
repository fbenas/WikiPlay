<?php

// Example html parser
// Uses the "Simple PHP DOM Parser"

include_once('simple_html_dom.php');

// A class that takes a wikipedia URL and stores the Page name
// and the description.
class scrape_wikipedia
{

    private $url;
    private $html; // html element holding the page contents.
    private $desc;
    private $heading;
    private $link_no;
    private $links;
    private $para;

    const FIRST_PARAGRAPH_CONST = "div #mw-content-text p";
    const HEADING_CONST = "#firstHeading span";

    public function __construct($url)
    {
        $this->url = $url;
        $error = $this->load_page();
        if ($error != '')
        {
            throw new Exception($error);
        }
    }

    // Load the page specfied by the url
    // Scrape the page for heading and desc
    // Return error string if error found
    // Return empty string if no error.
    private function load_page()
    {
        // Load the page into the $html var
        $this->html = new simple_html_dom();

        // Check url for valid wiki page.
        if(!strstr($this->url,"wikipedia.org/wiki"))
        {
            return "Not a valid link. ('". $this->url ."')";
        }

        $this->html->load_file($this->url);
        
        if(is_null($this->html))
        {
            return "Could not load file. ('" . $this->url . "'')";
        }
        
        // load the first paragraph's links and initalise pointer.
        $this->load_links();

        // Get the heading
        $element = $this->html->find($this::HEADING_CONST);
        if(is_null($element))
        {
            return "Could not retrive page heading. ('". $this->url . "'')";
        }

        $this->heading =  strip_tags( $element[0]->innertext );

        // Get the description (first paragraph)
        $element = $this->html->find($this::FIRST_PARAGRAPH_CONST);

        if(is_null($element))
        {
            return "Could not retrive page description. ('". $this->url . "')";

        }
        if($this->para = 0)
        {
            return "No valid description could be found. ('". $this->url . "')";
        }
        else
        {
            $this->desc = $element[$this->para]->innertext;
        }
    }

    // Get's the next link from the description
    // The pointer for this is stored in $link_no
    public function get_next_link()
    {
        // check the link exists.
        if(count($this->links) <= $this->link_no)
        {
            return "";
        }
        else
        {
            $link = $this->links[$this->link_no]->outertext;
            $this->link_no++;
            return $link;
        }
    }

    public function reset_links()
    {
        // reset the link counter to 0
        $this->link_no = 0;
    }

    // Get the link at the provided index
    public function get_link($index)
    {   
        if($index < sizeof($this->links))
        {
            return $this->links[$index];
        }
    }

    public function get_link_count()
    {
        return $this->link_no;
    }

    public function get_links()
    {
        return $this->links;
    }
    
    private function load_links()
    {
        // set the $link_no pointer to 0.
        $this->link_no = 0;

        // Remove first table 
        // bug #1 on github.
        if(isset($this->html->find('div #mw-content-text table')[0]))
        {
            $element = $this->html->find('div #mw-content-text table')[0];
            $element->innertext = '';
        }
        $this->html->load($this->html->save());  

        // Remove coords
        if($this->html->find('#coordinates'))
        {
            $this->html->find('#coordinates')[0]->innertext = '';  
        }
        $this->html->load($this->html->save()); 
        
        $this->para = 0;
        $fail = false;
        while (    !$this->html->find($this::FIRST_PARAGRAPH_CONST)
                || !isset($this->html->find($this::FIRST_PARAGRAPH_CONST)[$this->para])
                || count($this->html->find($this::FIRST_PARAGRAPH_CONST)[$this->para]->find("a")) == 0 
                || count($this->html->find($this::FIRST_PARAGRAPH_CONST)[$this->para]->find("ul")) != 0)
        {
            if($this->para > 5)
            {
                $fail = true;
                break;
            }
            $this->para++;
        }

        if($fail == true)
        {
            $this->links = null;
            $this->link_no = 0;
        }
        else
        {
            $this->links = $this->html->find($this::FIRST_PARAGRAPH_CONST)[$this->para]->find("a");
            
            $returnArray = array();
            $arrayCount =0;
            for($i=0; $i< count($this->links); $i++)
            {
                if(    !strstr($this->links[$i]->outertext,"IPA") 
                    && !strstr($this->links[$i]->outertext,"<sup>")
                    && !strstr($this->links[$i]->outertext,"#cite_note")
                    && !strstr($this->links[$i]->outertext,'href="//en.wiktionary.org'))
                {
                    $returnArray[$arrayCount] = $this->links[$i]->outertext;
                    $arrayCount++;
                }
                // limit to 10
                if($arrayCount > 10)
                {
                    break;
                }
            }
            $this->links = $returnArray;
            $this->link_no = count($this->links);
        }
    }

    // Reload the html page into the vars
    // and re-get the heading and description
    public function reload_page()
    {
        return $this->load_page();
    }

    // Set a new URL and reload the page
    public function set_url($url)
    {
        $this->url = $url;
        return $this->load_page();
    }

    public function get_url()
    {
        return $this->url;
    }

    public function get_description()
    {
        return $this->desc;
    }

    public function get_heading()
    {
        return $this->heading;
    }

    // Static method that returns a random wikipedia article
    // Returns a scrape_wikipedia object with the random article.
    public static function get_random_article()
    {
        // Use wget to get the redirected url
        // NOTE: certainly better to use CURL here. I'm on a gentoo machine and my php hasn't got the 
        // curl module enabled. I don't want to recompile at this time. 
        // Sometimes using linux utils is more fun anyway.
        // (I have also just discovered the best way for me to "reverse engineer" shortered URLs. woo.)
        // That wouldn't of happened if I didn't do this :D
        $redirect_url = exec('wget -O /dev/null https://en.wikipedia.org/wiki/Special:Random 2>&1 | grep Location | cut -f2 -d" "');

        // Create instance of self to get the heading and description.
        //return new scrape_wikipedia($redirect_url);
        return new scrape_wikipedia($redirect_url);
    }
}
?>