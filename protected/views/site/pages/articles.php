<h1>Articles</h1>

<form action="" method="post" class="bootstrap-frm">
    <h1>Filter Form 
        <span>Please fill fields you want to filter.</span>
    </h1>
    <label>
        <span>Author name:</span>
        <input id="author-name" type="text" name="author-name" placeholder="Author Name" />
    </label>
    
    <label>
        <span>Article name:</span>
        <input id="article-name" type="text" name="article-name" placeholder="Article name" />
    </label>
    
     <label>
        <span>Category:</span><select name="category">
        <option value="Computer Science">Computer Science</option>
		<option value="History">History</option>
		<option value="Languages">Languages</option>
		<option value="all">All</option>
        </select>
    </label>  

    <label>
        <span>Index:</span><select name="index-value">
        <option value="low">from lower to higher</option>
		<option value="high">from higher to lower</option>
        </select>
    </label>      
     <label>
        <span>&nbsp;</span> 
        <input type="button" class="button" value="Filter" /> 
    </label>    
</form>

	<table class="index-table">
		<tr>
			<td>Raiting</td>
			<td>Author</td>
			<td>Article</td>
			<td>Category</td>
			<td>Index Citation</td>
			<td>Download link</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Test</td>
			<td>Test</td>
			<td>Computer Science</td>
			<td>0.7788</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
		<tr>
			<td>2</td>
			<td>Test</td>
			<td>Test</td>
			<td>Computer Science</td>
			<td>0.7688</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
		<tr>
			<td>3</td>
			<td>Test</td>
			<td>Test</td>
			<td>Languages</td>
			<td>0.6688</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
		<tr>
			<td>4</td>
			<td>Test</td>
			<td>Test</td>
			<td>Computer Science</td>
			<td>0.6588</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
		<tr>
			<td>5</td>
			<td>Test</td>
			<td>Test</td>
			<td>Computer Science</td>
			<td>0.6488</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
		<tr>
			<td>6</td>
			<td>Test</td>
			<td>Test</td>
			<td>History</td>
			<td>0.5688</td>
			<td><a href="#"><img src="/images/pdf.png">></a><td>
		</tr>
	</table>
