def lucky_sevens(array)
	return true
end

puts(lucky_sevens?([2,1,5,1,0]) == true).to_s
puts(lucky_sevens?([0,-2,1,8]) == true).to_s
puts(lucky_sevens?([7,7,7,7]) == false).to_s
puts(lucky_sevens?([3,4,3,4]) == false).to_s