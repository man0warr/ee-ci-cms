
<div id="search-results">

    <h1>Search Results:</h1>

    <?php if ($results): ?>

        <!-- Display Results -->
        <ol>
            <?php foreach ($results as $result): ?>
                <li>
                    <h2><a href="<?php echo $result['url']; ?>"><?php echo $result['title']; ?></a></h2>
                    <p>
                        <?php echo $result['snippet']; ?>
                    </p>
                    <p>
                    	<a href="<?php echo $result['url']; ?>"><?php echo $result['url']; ?></a><br>
	                    <?php echo $result['occurances']; ?>, <strong>Last updated on</strong> <?php echo $result['modified_date']; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ol>

    <?php else: ?>

        <!-- No Results Message -->
        <p>No results found for <strong class="search-term"><?php echo $search_term; ?>.</strong></p>

    <?php endif; ?>

</div>
