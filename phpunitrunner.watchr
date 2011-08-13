def run(cmd)
  cmd = "phpunitrunner --phpunit-config=phpunit.xml -c #{cmd}"
  puts "$ #{cmd}"
  system cmd
end

watch("^src/(.*).php")   { |m| run "tests/#{m[1]}Test.php" }
watch("^tests/(.*).php") { |m| run "tests/#{m[1]}.php" }
